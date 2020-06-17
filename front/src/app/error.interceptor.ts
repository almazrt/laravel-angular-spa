import {Injectable} from '@angular/core';
import {HttpRequest, HttpHandler, HttpEvent, HttpInterceptor} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError} from 'rxjs/operators';

import {AuthService} from './auth.service';
import {ToastrService} from 'ngx-toastr';
import {Router} from '@angular/router';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
  constructor(private authService: AuthService, private toastr: ToastrService, private router: Router) {
  }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(catchError(err => {
      switch (err.status) {
        case 401:
          this.authService.logout();
          location.reload(true);
          break;
        case 422:
          for (const prop in err.error.errors) {
            if (err.error.errors.hasOwnProperty(prop)) {
              this.toastr.error(err.error.errors[prop]);
            }
          }
          break;
        case 400:
          if (err.error.message) {
            this.toastr.error(err.error.message);
          }
          if (err.error.newUrl) {
            this.router.navigateByUrl(err.error.newUrl);
            // this.router.navigate([err.error.newUrl.url], {queryParams: err.error.newUrl.params});
          }
      }

      const error = err.error.message || err.statusText;
      return throwError(error);
    }));
  }
}
