import {Component, OnInit} from '@angular/core';
import {Item} from '../../items/item';
import {Notification, NOTIFICATION_TYPES} from '../../notifications/notification';
import {NotificationService} from '../../notifications/notification.service';

@Component({
  selector: 'app-notifications',
  templateUrl: './notifications.component.html',
  styleUrls: ['./notifications.component.scss']
})
export class NotificationsComponent implements OnInit {
  notifications: {
    data: Notification[],
    current_page: number,
    from: number,
    total: number,
  } = {
    data: [],
    current_page: 0,
    from: 0,
    total: 0,
  };

  NOTIFICATION_TYPES = NOTIFICATION_TYPES;

  constructor(private notificationService: NotificationService) {
  }

  loadNotifications(status = null) {
    this.notificationService.getMyNotifications().subscribe((data: any) => {
      this.notifications = data;
    });
  }

  ngOnInit() {
    this.loadNotifications(null);
  }

}
