import {Injectable} from '@angular/core';
import {Item} from '../items/item';
import {HttpClient} from '@angular/common/http';
import {Review} from './review';

@Injectable({
  providedIn: 'root'
})
export class ReviewService {

  constructor(private http: HttpClient) {
  }

  setReview(review: Review) {
    return this.http.post<any>('/api/my/reviews', review);
  }

}
