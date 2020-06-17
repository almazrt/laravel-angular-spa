import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {ActivatedRoute, ActivatedRouteSnapshot, Router, RouterStateSnapshot} from '@angular/router';
import {AuthService} from '../auth.service';
import {tap} from 'rxjs/operators';
import {ToastrService} from 'ngx-toastr';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  userInfo = {
    phone: null,
    userId: null,
    code: null,
  };

  ngOnInit() {
  }

  constructor(
    private authService: AuthService,
    private router: Router,
    private toastr: ToastrService,
    private route: ActivatedRoute) {
  }

  register() {
    this.authService.register(this.userInfo.phone).subscribe((data: any) => {
      this.userInfo.userId = data.userId;
    });
  }

  confirm() {
    this.authService.confirm(this.userInfo.userId, this.userInfo.code).subscribe(data => {
      this.toastr.success('Ассаламу алейкум!');

      this.route.queryParams.subscribe(params => {
        this.router.navigateByUrl(params.returnUrl ? params.returnUrl : '/my');
      });

    });
  }

}
