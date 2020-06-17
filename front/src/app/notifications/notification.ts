import {User} from '../users/user';
import {Category} from '../categories/category';
import {City} from '../cities/city';

export class Notification {
  id: number;
  user_id: number;
  title: string;
  description: string;
  type: number;
  status: number;
  created_at: Date;
}

export const NOTIFICATION_STATUSES = {
  STATUS_NEW: {value: 1, title: 'Новый'},
  STATUS_NOTIFIED: {value: 2, title: 'Уведомление отправлено'},
  STATUS_READ: {value: 3, title: 'Прочитано'},
};

export const NOTIFICATION_TYPES = {
  TYPE_INFO: {value: 1, title: 'Информация'},
  TYPE_SUCCESS: {value: 2, title: 'Успешно'},
  TYPE_ERROR: {value: 3, title: 'Ошибка'},
};
