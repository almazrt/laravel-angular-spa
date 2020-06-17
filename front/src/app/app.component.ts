import {Component, OnInit} from '@angular/core';
import * as $ from 'jquery';
import {AuthService} from './auth.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'Специалисты своего дела среди мусульман';

  constructor() {
  }

  ngOnInit(): void {
    $(document).ready(() => {
      $(document).on('click', '.sidebar-dropdown > a', function () {
        $('.sidebar-submenu').slideUp(200);
        if (
          $(this)
            .parent()
            .hasClass('active')
        ) {
          $('.sidebar-dropdown').removeClass('active');
          $(this)
            .parent()
            .removeClass('active');
        } else {
          $('.sidebar-dropdown').removeClass('active');
          $(this)
            .next('.sidebar-submenu')
            .slideDown(200);
          $(this)
            .parent()
            .addClass('active');
        }
      });

      $('#close-sidebar').click(() => {
        $('.page-wrapper').removeClass('toggled');
      });
      $('#show-sidebar').click(() => {
        $('.page-wrapper').addClass('toggled');
      });

    });
  }
}
