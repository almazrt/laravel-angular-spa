import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Item, ITEM_STATUSES} from './item';
import {Subject} from 'rxjs';
import {find, map, tap} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ItemService {
  public page: number = null;
  public categoryId: number = null;
  public cityId: number = null;
  private termsSource = new Subject<string>();
  terms$ = this.termsSource.asObservable();

  constructor(private http: HttpClient) {
  }

  setTerm(term: string) {
    this.termsSource.next(term);
  }

  getItems(page: number, categoryId: number = null, cityId: number = null, term: string = null) {
    this.page = page;
    this.categoryId = categoryId;
    this.cityId = cityId;

    return this.http.get<any>('/api/items?page=' + page +
      (categoryId ? '&categoryId=' + categoryId : '') +
      (cityId ? '&cityId=' + cityId : '') +
      (term ? '&term=' + term : ''));
  }

  getMyItems(status: number = null) {
    return this.http.get<any>('/api/my/items?status=' + status);
  }

  getMyItem(id: number) {
    return this.http.get<Item>('/api/my/items/' + id);
  }

  setMyItem(item: Item) {
    return this.http.post<any>('/api/my/items', item);
  }

  deleteMyItem(id: number) {
    return this.http.delete<any>('/api/my/items/' + id);
  }

  getItem(id: number) {
    return this.http.get<Item>('/api/items/' + id);
  }

  getContacts(id: number) {
    return this.http.get<Item>('/api/items/' + id + '/contacts');
  }

}
