import {Component, OnInit} from '@angular/core';
import {AuthService} from "../../auth.service";
import {UserService} from "../../users/user.service";
import {ToastrService} from "ngx-toastr";

@Component({
  selector: 'app-settings',
  templateUrl: './settings.component.html',
  styleUrls: ['./settings.component.scss']
})
export class SettingsComponent implements OnInit {

  name: string;

  constructor(
    public authService: AuthService,
    private userService: UserService,
    private toastr: ToastrService
  ) {
    this.name = authService.getCurrentUser().name;
  }

  save(): void {
    this.userService.setCurrentUserName(this.name).subscribe(() => {
      const user = this.authService.getCurrentUser();
      user.name = this.name;
      localStorage.setItem('current_user', JSON.stringify(user));
      this.toastr.success('Сохранено.');
    });
  }

  ngOnInit(): void {
  }

}
