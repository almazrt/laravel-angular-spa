import {Injectable} from '@angular/core';
import {Item} from '../../items/item';
import {HttpClient} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ServicesService {

  constructor(private http: HttpClient) {
  }

  requestServices(services: any) {
    return this.http.post<any>('/api/my/services', services);
  }

}
