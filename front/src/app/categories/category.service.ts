import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Category} from './category';

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  constructor(private http: HttpClient) {
  }

  getCategory(id: number) {
    return this.http.get<Category>('/api/categories/' + id);
  }

  getCategories() {
    return this.http.get<Category[]>('/api/categories');
  }

}
