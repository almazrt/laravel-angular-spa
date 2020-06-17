import {Component, OnInit} from '@angular/core';
import {Category} from '../categories/category';
import {CategoryService} from '../categories/category.service';
import {ActivatedRoute, ActivatedRouteSnapshot, Router} from '@angular/router';
import {CityService} from '../cities/city.service';
import {City} from '../cities/city';
import {AuthService} from '../auth.service';
import {ItemService} from '../items/item.service';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.scss']
})
export class MenuComponent implements OnInit {

  public categories: Category[];
  public cityId: number = null;
  public categoryId: number = null;
  public cities: City[];

  constructor(
    private categoryService: CategoryService,
    private router: Router,
    public itemService: ItemService,
    public authService: AuthService,
    private cityService: CityService) {
  }

  ngOnInit(): void {
    this.categoryService.getCategories().subscribe((data: Category[]) => {
      this.categories = data;
    });

    this.cityService.getCities().subscribe((data: City[]) => {
      this.cities = data;
    });
  }

  setNew() {
    this.itemService.getItems(1, 126, 2);
  }

  onChangeCity(event) {
    let url = '/';
    if (this.itemService.categoryId) {
      url += '/category/' + this.itemService.categoryId;
    }

    if (event) {
      url += '/city/' + event.id;
    }

    url = url.replace(/\/\//, '/');

    this.router.navigate([url]);
  }

}
