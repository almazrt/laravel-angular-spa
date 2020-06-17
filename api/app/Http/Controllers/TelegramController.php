<?php

namespace App\Http\Controllers;

use App\City;
use App\Item;
use App\Libs\Telegram;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TelegramController extends Controller
{
    const MESSAGE_MAPPING = [
        '/' => 'start',
        '/start' => 'start',
        '/help' => 'help',
        'Работать' => 'doit',
        'Справка' => 'help',
        'Новый город' => 'newCity',
        'Новый пользователь' => 'newUser2',
    ];

    const MESSAGE_LIKE_MAPPING = [
        '/user' => 'findUserById',
        '/newuser' => 'newuser',
        'newuser' => 'newuser',
        'activateUser' => 'activateUser',
        'blockUser' => 'blockUser',
        '/item' => 'findItemById',
        'acceptItem' => 'acceptItem',
        'rejectItem' => 'rejectItem',
        'editItem' => 'editItem',
        'authUser' => 'authUser',
    ];

    const MAIN_MENU_KEYBOARD = [
        'keyboard' => [
            [
                ['text' => 'Работать'],
                ['text' => 'Справка'],
                ['text' => 'Новый город'],
                ['text' => 'Новый пользователь'],
            ]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => false,
        'selective' => true
    ];

    public function webhook()
    {
        if (env('APP_ENV') === 'local') {
            $updates = Telegram::getUpdates();
//        var_dump(json_encode($updates));
            foreach ($updates->result as $update) {
                $this->resolve($update);
            }
        } else {
            $input = file_get_contents('php://input');
            $update = json_decode($input);
            if ($this->permits($update)) {
                $this->resolve($update);
                \Log::debug('Permit');
            } else {
                \Log::debug('Not permit');
            }
        }
    }

    public function permits(\stdClass $update)
    {
        $telegramAdminChatIds = array_map('intval', explode(',', env('TELEGRAM_ADMIN_CHAT_IDS', 3153143)));
        \Log::debug(env('TELEGRAM_ADMIN_CHAT_IDS', 3153143));
        \Log::debug(explode(',', env('TELEGRAM_ADMIN_CHAT_IDS', 3153143)));
        \Log::debug(['current' => $this->getChatIdFromUpdate($update), $telegramAdminChatIds]);
        return in_array($this->getChatIdFromUpdate($update), $telegramAdminChatIds);
    }

    public function resolve(\stdClass $update)
    {
        foreach (self::MESSAGE_MAPPING as $key => $value) {
            if (isset($update->message) && $update->message->text === $key) {
                $id = preg_replace('/\D/', '', $update->message->text);
                Cache::forget('nextActionFor' . $this->getChatIdFromUpdate($update));
                $this->$value($id, $update);
                return true;
            } elseif (isset($update->callback_query) && $update->callback_query->data === $key) {
                $id = preg_replace('/\D/', '', $update->callback_query->data);
                Cache::forget('nextActionFor' . $this->getChatIdFromUpdate($update));
                $this->$value($id, $update);
                return true;
            }
        }

        foreach (self::MESSAGE_LIKE_MAPPING as $key => $value) {
            if (isset($update->message) && strpos($update->message->text, $key) !== false) {
                $id = preg_replace('/\D/', '', $update->message->text);
                Cache::forget('nextActionFor' . $this->getChatIdFromUpdate($update));
                $this->$value($id, $update);
                return true;
            } elseif (isset($update->callback_query) && strpos($update->callback_query->data, $key) !== false) {
                $id = preg_replace('/\D/', '', $update->callback_query->data);
                Cache::forget('nextActionFor' . $this->getChatIdFromUpdate($update));
                $this->$value($id, $update);
                return true;
            }
        }

        if ($action = Cache::get('nextActionFor' . $this->getChatIdFromUpdate($update))) {
            $id = preg_replace('/\D/', '', $update->message->text);
            $this->$action($id, $update);
        }

        return false;
    }

    public function createCity($id, $update)
    {
        $city = City::firstOrCreate(['name' => $update->message->text]);
        $text = "Город {$city->name} добавлен.";
        Telegram::sendMessage($this->getChatIdFromUpdate($update), $text);
        Cache::forget('nextActionFor' . $this->getChatIdFromUpdate($update));
    }

    public function createUser($id, $update)
    {
        $phone = $update->message->text;
        $phone = preg_replace('/\D/', '', $phone);
        $phone = substr($phone, -10, 10);

        if (!$user = User::where('phone', $phone)->first()) {
            $user = User::create(['phone' => $phone, 'rating' => 0, 'status' => User::STATUS_NEW]);
            $user->name = 'User' . $user->id;
        }
        $user->save();

        $text = "Пользователь /user{$user->id} добавлен.";

        Telegram::sendBigMessage($this->getChatIdFromUpdate($update), $text);
        Cache::forget('nextActionFor' . $this->getChatIdFromUpdate($update));
    }

    public function newCity($id, $update)
    {
        $text = "Напишите название города";
        Telegram::sendMessage($this->getChatIdFromUpdate($update), $text);
        \Cache::add('nextActionFor' . $this->getChatIdFromUpdate($update), 'createCity');
    }

    public function newUser2($id, $update)
    {
        $text = "Напишите номер телефона пользователя";
        Telegram::sendMessage($this->getChatIdFromUpdate($update), $text);
        \Cache::add('nextActionFor' . $this->getChatIdFromUpdate($update), 'createUser');
    }

    public function newuser($id, $update)
    {
        if (!$user = User::where('phone', $id)->first()) {
            $user = User::create(['phone' => $id, 'rating' => 0, 'status' => User::STATUS_NEW]);
            $user->name = 'User' . $user->id;
        }
        $user->save();

        $text = "Пользователь /user{$user->id} создан.";

        Telegram::sendBigMessage($this->getChatIdFromUpdate($update), $text);
    }

    public function help($id, $update)
    {
        $text = <<<TXT
Справка по командам:
/user1 - найти пользователя с ID 1
/item1 - найти объявление с ID 1
/newuser9600385016 - создать пользователя по номеру телефона (обязательно без 8 или +7 !)
TXT;
        Telegram::sendMessage($this->getChatIdFromUpdate($update), $text, self::MAIN_MENU_KEYBOARD);
    }

    public function doit($id, $update)
    {
        if ($item = Item::new()->orderBy('updated_at', 'desc')->first()) {
            $text = <<<TXT
Задание.
Нужно привести к стандарту объявление /item{$item->id} и Принять его.
Для редактирования нажмите Редактировать.
Если объявление не подходит под наш сайт - Отклонить.
TXT;
        } else {
            $text = 'Пока нет заданий.';
        }
        Telegram::sendMessage($this->getChatIdFromUpdate($update), $text, self::MAIN_MENU_KEYBOARD);
    }

    public function start($id, $update)
    {
        $text = <<<TXT
Ассаламу алейкум. Чтобы начать работать, нажмите Работать.
TXT;
        Telegram::sendMessage($this->getChatIdFromUpdate($update), $text, self::MAIN_MENU_KEYBOARD);
    }

    public function authUser($id, $update)
    {
        if (!$user = User::find($id)) return false;
        $user->verification_token = md5($user->id . '_' . time() . rand(0, 999999));
        $user->save();

        $url = "https://muslim-skills.com/autologin/{$user->verification_token}/%2Fmy";

        Telegram::sendBigMessage($this->getChatIdFromUpdate($update), $url);
    }

    public function editItem($id, $update)
    {
        if (!$item = Item::find($id)) return false;
        if (!$user = User::find($item->user_id)) return false;
        $user->verification_token = md5($user->id . '_' . time() . rand(0, 999999));
        $user->save();

        $url = "https://muslim-skills.com/autologin/{$user->verification_token}/%2Fmy%2Fitems%2F{$id}%2Fedit";

        Telegram::sendBigMessage($this->getChatIdFromUpdate($update), $url);
    }

    public function activateUser($id, $update)
    {
        User::where('id', $id)->update(['status' => User::STATUS_ACTIVE]);
        $this->findUserById($id, $update);
    }

    public function blockUser($id, $update)
    {
        User::where('id', $id)->update(['status' => User::STATUS_BLOCKED]);
        $this->findUserById($id, $update);
    }

    public function acceptItem($id, $update)
    {
        Item::where('id', $id)->update(['status' => Item::STATUS_ACTIVE]);
        $this->findItemById($id, $update);
    }

    public function rejectItem($id, $update)
    {
        Item::where('id', $id)->update(['status' => Item::STATUS_REJECTED]);
        $this->findItemById($id, $update);
    }

    public function findUserById($id, $update)
    {
        if (!$user = User::find($id)) return false;

        $userStatusName = User::STATUS_NAMES[$user->status];
        $userItems = array_reduce($user->items()->pluck('id')->toArray(), function ($accum, $id) {
            return $accum . ' /item' . $id;
        });

        $message = <<<MSG
#{$user->id}
Имя: {$user->name}
Статус: {$userStatusName}
Телефон: {$user->phone}
Объявления: {$userItems}
MSG;

        $replyMarkup = [
            'inline_keyboard' => [[
                ['text' => 'Активировать', 'callback_data' => 'activateUser' . $user->id],
                ['text' => 'Заблокировать', 'callback_data' => 'blockUser' . $user->id],
                ['text' => 'Войти под именем', 'callback_data' => 'authUser' . $user->id],
            ]],
        ];

        Telegram::sendBigMessage($this->getChatIdFromUpdate($update), $message, $replyMarkup);

    }

    public function findItemById($id, $update)
    {
        if (!$item = Item::find($id)) return false;

        $statusName = Item::STATUS_NAMES[$item->status];
        $cityName = $item->city->name;
        $categoryName = $item->category->name;

        $contacts = '';
        $contacts .= $item->phone ? "Телефон: {$item->phone}\n" : '';
        $contacts .= $item->whatsapp ? "WhatsApp: https://api.whatsapp.com/send?phone={$item->whatsapp}\n" : '';
        $contacts .= $item->insta ? "Instagram: https://www.instagram.com/{$item->insta}\n" : '';
        $contacts .= $item->telegram ? "Telegram: https://t.me/{$item->telegram}\n" : '';
        $contacts .= $item->vk ? "Vk: {$item->vk}\n" : '';
        $contacts .= $item->fb ? "Facebook: {$item->fb}\n" : '';
        $contacts .= $item->website ? "Сайт: {$item->website}\n" : '';
        $contacts .= $item->address ? "Адрес: {$item->address}\n" : '';
        $contacts .= $item->other_contacts ? "Другое: {$item->other_contacts}\n" : '';

        $message = <<<MSG
#{$item->id}
Заголовок: {$item->title}
Статус: {$statusName}
Город: {$cityName}
Раздел: {$categoryName}
Пользователь: /user{$item->user_id}
Текст:
{$item->description}

Контакты:
{$contacts}
MSG;

        $replyMarkup = [
            'inline_keyboard' => [[
                ['text' => 'Принять', 'callback_data' => 'acceptItem' . $item->id],
                ['text' => 'Отклонить', 'callback_data' => 'rejectItem' . $item->id],
                ['text' => 'Редактировать', 'callback_data' => 'editItem' . $item->id],
            ]],
        ];

        Telegram::sendBigMessage($this->getChatIdFromUpdate($update), $message, $replyMarkup);

    }

    public function getChatIdFromUpdate($update)
    {
        return isset($update->message->from->id) ? $update->message->from->id : (isset($update->callback_query->from->id) ? $update->callback_query->from->id : null);
    }


}
