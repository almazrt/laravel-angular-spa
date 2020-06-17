import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import * as moment from 'moment';
import {catchError, tap} from 'rxjs/operators';
import {Router} from '@angular/router';
import {Observable} from 'rxjs';
import {ToastrService} from 'ngx-toastr';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private http: HttpClient, private router: Router) {
  }

  register(phone: string): Observable<any> {
    return this.http.post<any>('/api/auth/register', {phone});
  }

  confirm(userId: number, code: string) {
    return this.http.post<any>('/api/auth/confirm', {userId, code})
      .pipe(tap(authResult => {
        localStorage.setItem('access_token', authResult.token);
        localStorage.setItem('expires_at', JSON.stringify(moment().add(999999, 'days').format('YYYY-MM-DD H:mm:ss')));
        localStorage.setItem('current_user', JSON.stringify(authResult.user));
      }));
  }

  autologin(token: string) {
    return this.http.post<any>('/api/auth/autologin', {token})
      .pipe(tap(authResult => {
        localStorage.setItem('access_token', authResult.token);
        localStorage.setItem('expires_at', JSON.stringify(moment().add(999999, 'days').format('YYYY-MM-DD H:mm:ss')));
        localStorage.setItem('current_user', JSON.stringify(authResult.user));
      }));
  }

  logout() {
    localStorage.removeItem('access_token');
    localStorage.removeItem('expires_at');
    localStorage.removeItem('current_user');
    this.router.navigate(['/login']);
  }

  public isLoggedIn() {
    return moment().isBefore(this.getExpiration());
  }

  public getCurrentUser() {
    return JSON.parse(localStorage.getItem('current_user'));
  }

  isLoggedOut() {
    return !this.isLoggedIn();
  }

  getExpiration() {
    return moment(JSON.parse(localStorage.getItem('expires_at')));
  }

}
