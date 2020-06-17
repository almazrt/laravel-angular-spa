import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {Location} from '@angular/common';
import {Item} from '../../../items/item';
import {ItemService} from '../../../items/item.service';
import {User} from '../../../users/user';
import {City} from '../../../cities/city';
import {Category} from '../../../categories/category';
import {ToastrService} from 'ngx-toastr';
import {AuthService} from '../../../auth.service';

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.scss']
})
export class ItemComponent implements OnInit {
  item: Item;
  contacts: Item;

  constructor(
    private itemService: ItemService,
    private route: ActivatedRoute,
    private router: Router,
    private location: Location,
    private toastr: ToastrService,
    private authService: AuthService) {
  }

  loadItem(id: number) {
    this.itemService.getMyItem(id).subscribe((data: Item) => {
      this.item = data;
    });
  }

  isShowBackButton() {
    return window.history.length > 2;
  }

  onBackClick() {
    this.location.back();
  }

  showContacts() {
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
