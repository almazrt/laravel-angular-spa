import {User} from '../users/user';
import {Category} from '../categories/category';
import {City} from '../cities/city';
import {Review} from '../reviews/review';

export class Item {
  id: number;
  user_id: number;
  category_id: number;
  city_id: number;
  title: string;
  description: string;
  rating: number;
  status: number;
  user: User;
  category: Category;
  city: City;
  reviews: Review[];
  phone: string;
  whatsapp: string;
  insta: string;
  telegram: string;
  vk: string;
  fb: string;
  website: string;
  address: string;
  other_contacts: string;
  user_name: string;
  user_rating: number;
}

export const ITEM_STATUSES = {
  STATUS_NEW: {value: 1, title: 'Ожидает проверки'},
  STATUS_MODERATING: {value: 2, title: 'На проверке'},
  STATUS_ACTIVE: {value: 3, title: 'Опубликовано'},
  STATUS_REJECTED: {value: 4, title: 'Отклонен'},
  STATUS_BLOCKED: {value: 5, title: 'Заблокирован'},
};
