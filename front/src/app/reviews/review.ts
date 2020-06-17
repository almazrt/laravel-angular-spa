import {User} from '../users/user';

export class Review {
  id: number;
  user_id: number;
  reviewer_user_id: number;
  value: number;
  description: string;
  status: number;
  reviewer: User;
}
