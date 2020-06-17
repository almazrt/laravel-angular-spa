<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<SQL
#SET foreign_key_checks = 0;
#truncate categories;
INSERT INTO categories (id, parent_id, name, status, icon, sort) VALUES (1, 1, 'Главная категория', 1, null, 100);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (125, 'Услуги', 1, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (126, 'IT, интернет, телеком', 125, 1, 0, 'fa-laptop');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (127, 'Cоздание и продвижение сайтов', 126, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (128, 'Установка и настройка ПО', 126, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (129, 'Настройка интернета и сетей', 126, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (130, 'Мастер на все случаи', 126, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (131, 'Бытовые услуги', 125, 1, 0, 'fa-wrench');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (132, 'Изготовление ключей', 131, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (133, 'Пошив и ремонт одежды', 131, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (134, 'Ремонт часов', 131, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (135, 'Химчистка, стирка', 131, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (136, 'Ювелирные услуги', 131, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (137, 'Деловые услуги', 125, 1, 0, 'fa-briefcase');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (138, 'Бухгалтерия, финансы', 137, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (139, 'Консультирование', 137, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (140, 'Набор и коррекция текста', 137, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (141, 'Перевод', 137, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (142, 'Юридические услуги', 137, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (143, 'Искусство', 125, 1, 0, 'fa-paint-brush');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (144, 'Красота, здоровье', 125, 1, 0, 'fa-spa');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (145, 'Услуги парикмахера', 144, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (146, 'Маникюр, педикюр', 144, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (147, 'Макияж', 144, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (148, 'Косметология, эпиляция', 144, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (149, 'СПА-услуги, здоровье', 144, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (151, 'Другое', 144, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (152, 'Курьерские поручения', 125, 1, 0, 'fa-people-carry');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (153, 'Мастер на час', 125, 1, 0, 'fa-wrench');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (154, 'Няни, сиделки', 125, 1, 0, 'fa-baby');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (155, 'Оборудование, производство', 125, 1, 0, 'fa-truck-loading');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (156, 'Аренда оборудования', 155, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (157, 'Монтаж и обслуживание оборудования', 155, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (158, 'Производство, обработка', 155, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (159, 'Обучение, курсы', 125, 1, 0, 'fa-book-open');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (160, 'Предметы школы и ВУЗа', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (161, 'Иностранные языки', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (162, 'Вождение', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (163, 'Музыка, театр', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (164, 'Спорт, танцы', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (165, 'Рисование, дизайн, рукоделие', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (166, 'Профессиональная подготовка', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (167, 'Детское развитие, логопеды', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (168, 'Другое', 159, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (169, 'Охрана, безопасность', 125, 1, 0, 'fa-shield-alt');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (170, 'Питание, кейтеринг', 125, 1, 0, 'fa-utensils');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (171, 'Праздники, мероприятия', 125, 1, 0, 'fa-gifts');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (172, 'Реклама, полиграфия', 125, 1, 0, 'fa-bullhorn');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (173, 'Маркетинг, реклама, PR', 172, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (174, 'Полиграфия, дизайн', 172, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (175, 'Ремонт и обслуживание техники', 125, 1, 0, 'fa-tablet-alt');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (176, 'Телевизоры', 175, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (177, 'Мобильные устройства', 175, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (178, 'Мелкая бытовая техника', 175, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (179, 'Фото-, аудио-, видеотехника', 175, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (180, 'Компьютерная техника', 175, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (181, 'Игровые приставки', 175, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (182, 'Крупная бытовая техника', 175, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (183, 'Ремонт, строительство', 125, 1, 0, 'fa-hammer');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (184, 'Сборка и ремонт мебели', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (185, 'Отделочные работы', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (186, 'Электрика', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (187, 'Сантехника', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (188, 'Ремонт офиса', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (189, 'Остекление балконов', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (190, 'Ремонт ванной', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (191, 'Строительство бань, саун', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (192, 'Ремонт кухни', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (193, 'Строительство домов, коттеджей', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (194, 'Ремонт квартиры', 183, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (195, 'Сад, благоустройство', 125, 1, 0, 'fa-seedling');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (196, 'Транспорт, перевозки', 125, 1, 0, 'fa-truck');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (197, 'Автосервис', 196, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (198, 'Аренда авто', 196, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (199, 'Коммерческие перевозки', 196, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (200, 'Грузчики', 196, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (201, 'Переезды', 196, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (202, 'Спецтехника', 196, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (203, 'Уборка', 125, 1, 0, 'fa-broom');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (204, 'Вывоз мусора', 203, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (205, 'Генеральная уборка', 203, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (206, 'Глажка белья', 203, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (207, 'Мойка окон', 203, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (208, 'Простая уборка', 203, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (209, 'Уборка после ремонта', 203, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (210, 'Чистка ковров', 203, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (211, 'Чистка мягкой мебели', 203, 1, 0, null);
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (212, 'Установка техники', 125, 1, 0, 'fa-chalkboard-teacher');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (213, 'Уход за животными', 125, 1, 0, 'fa-horse');
INSERT INTO categories (id, name, parent_id, status, sort, icon) VALUES (214, 'Фото- и видеосъёмка', 125, 1, 0, 'fa-video');
INSERT INTO categories (id, name, parent_id, status, sort, icon, sort) VALUES (215, 'Другое', 125, 1, 0, 'fa-circle-notch', 10);
update categories set sort=100 where sort is null;
SQL;

        Db::unprepared($sql);
    }
}
