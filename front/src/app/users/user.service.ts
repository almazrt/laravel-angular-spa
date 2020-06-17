import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {User} from './user';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient) {
  }

  getCurrentUser() {
    return this.http.get<User>('/api/my/user');
  }

  setCurrentUser(user: User) {
    return this.http.post<User>('/api/my/user', user);
  }

  setCurrentUserName(name: string) {
    return this.http.post<User>('/api/my/user', {name});
  }

}
