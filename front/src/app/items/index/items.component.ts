import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {ActivatedRoute, Params, Router} from '@angular/router';
import {Item} from '../item';
import {Category} from '../../categories/category';
import {ItemService} from '../item.service';
import {CategoryService} from '../../categories/category.service';

@Component({
  selector: 'app-items',
  templateUrl: './items.component.html',
  styleUrls: ['./items.component.scss']
})
export class ItemsComponent implements OnInit {
  items: {
    data: Item[],
    current_page: number,
    from: number,
    total: number,
  } = {
    data: [],
    current_page: 0,
    from: 0,
    total: 0,
  };
  category: Category;
  private categoryId: number = null;
  private cityId: number = null;

  constructor(
    private itemService: ItemService,
    private categoryService: CategoryService,
    private router: Router,
    private route: ActivatedRoute) {
  }

  loadCategory(categoryId?: number) {
    if (!categoryId) {
      return;
    }

    this.categoryService.getCategory(categoryId).subscribe((data: any) => {
      this.category = data;
    });
  }

  loadItems(page: number = 1, categoryId = null, cityId = null, term = null) {
    this.itemService.getItems(page, categoryId, cityId, term).subscribe((data: any) => {
      this.items = data;
      const scrollToTop = window.setInterval(() => {
        const pos = window.pageYOffset;
        if (pos > 0) {
          window.scrollTo(0, pos - 20); // how far to scroll on each step
        } else {
          window.clearInterval(scrollToTop);
        }
      }, 16);
    });
  }

  paginate(page: number) {
    const queryParams: Params = {page};
    this.router.navigate(
      [],
      {
        relativeTo: this.route,
        queryParams,
        queryParamsHandling: 'merge', // remove to replace all query params by provided
      });
  }

  ngOnInit() {
    this.category = new Category();
    this.category.name = 'Специалисты своего дела среди мусульман';

    this.route.params.subscribe(params => {

      this.categoryId = params.categoryId ? params.categoryId : null;
      this.cityId = params.cityId ? params.cityId : null;

      this.route.queryParams.subscribe(qp => {
        this.loadItems(qp && qp.page ? qp.page : 1, this.categoryId, this.cityId);
        this.loadCategory(this.categoryId);
      });

    });

    this.itemService.terms$.subscribe(
      term => {
        this.loadItems(1, this.categoryId, this.cityId, term);
      });

  }

}
