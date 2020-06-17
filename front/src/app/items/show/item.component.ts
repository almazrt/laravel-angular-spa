import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {Location} from '@angular/common';
import {Item} from '../item';
import {ItemService} from '../item.service';
import {User} from '../../users/user';
import {City} from '../../cities/city';
import {Category} from '../../categories/category';
import {AuthService} from '../../auth.service';
import {ToastrService} from 'ngx-toastr';
import {Review} from '../../reviews/review';
import {ReviewService} from '../../reviews/review.service';

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.scss']
})
export class ItemComponent implements OnInit {
  item: Item;
  contacts: Item;
  newReview = false;
  review: Review = new Review();

  constructor(
    private itemService: ItemService,
    private route: ActivatedRoute,
    private router: Router,
    private location: Location,
    private toastr: ToastrService,
    private reviewService: ReviewService,
    public authService: AuthService) {
  }

  saveReview() {
    this.reviewService.setReview(this.review).subscribe(review => {
      this.toastr.success('Отзыв отправлен.');
      this.newReview = null;
    });
  }

  loadItem(id: number) {
    this.itemService.getItem(id).subscribe((data: Item) => {
      this.item = data;
      this.review.value = 5;
      this.review.user_id = this.item.user_id;
      this.review.reviewer_user_id = this.authService.getCurrentUser().id;
    });
  }

  isShowBackButton() {
    return window.history.length > 2;
  }

  onBackClick() {
    this.location.back();
  }

  showContacts() {
    if (!this.authService.isLoggedIn()) {
      this.toastr.error('Для того чтобы смотреть контакты, нужно зарегистрироваться.');
      this.router.navigateByUrl('/login?returnUrl=/items/' + this.item.id);
      return;
    }
    this.itemService.getContacts(this.item.id).subscribe((data: Item) => {
      this.contacts = data;
    });
  }

  ngOnInit(): void {
    this.item = new Item();
    this.item.user = new User();
    this.item.city = new City();
    this.item.category = new Category();
    this.route.params.subscribe(params => {
      if (params.id) {
        this.loadItem(params.id);
      }
    });
  }

}
