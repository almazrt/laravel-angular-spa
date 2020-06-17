import {Component, OnInit} from '@angular/core';
import {ServicesService} from './services.service';
import {ToastrService} from 'ngx-toastr';
import {Router} from '@angular/router';
import {AuthService} from '../../auth.service';

@Component({
  selector: 'app-services',
  templateUrl: './services.component.html',
  styleUrls: ['./services.component.scss']
})
export class ServicesComponent implements OnInit {

  services = {
    showCallback: false,
    subject: '',
    whatsapp: '',
    name: ''
  };

  constructor(
    private servicesService: ServicesService,
    private toastr: ToastrService,
    private router: Router,
  ) {
  }

  prepareCallback(subject: string) {
    this.services.showCallback = true;
    this.services.subject = subject;
  }

  sendCallback() {
    this.servicesService.requestServices(this.services).subscribe(s => {
      this.services.showCallback = false;
      this.toastr.success('Запрос отправлен. Мы свяжемся с вами по whatsapp.');
      this.router.navigateByUrl('/my');
    });
  }

  ngOnInit(): void {
  }

}
