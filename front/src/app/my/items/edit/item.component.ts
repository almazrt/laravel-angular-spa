import {Component, Input, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {ModalDismissReasons, NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {ToastrService} from 'ngx-toastr';
import {Item} from '../../../items/item';
import {User} from '../../../users/user';
import {Category} from '../../../categories/category';
import {City} from '../../../cities/city';
import {CategoryService} from '../../../categories/category.service';
import {ItemService} from '../../../items/item.service';
import {CityService} from '../../../cities/city.service';
import {UserService} from '../../../users/user.service';

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.scss']
})
export class ItemComponent implements OnInit {
  item: Item = new Item();
  user: User = new User();
  closeResult: string;
  selectedCategory: Category;
  cities: City[];
  moreContacts = false;

  constructor(
    private categoryService: CategoryService,
    private itemService: ItemService,
    private route: ActivatedRoute,
    private router: Router,
    private modalService: NgbModal,
    private cityService: CityService,
    private userService: UserService,
    private toastr: ToastrService
  ) {
    this.item.category = new Category();
  }

  private getDismissReason(reason: any): string {
    if (reason === ModalDismissReasons.ESC) {
      return 'by pressing ESC';
    } else if (reason === ModalDismissReasons.BACKDROP_CLICK) {
      return 'by clicking on a backdrop';
    } else {
      return `with: ${reason}`;
    }
  }

  setCategory(category: Category) {
    this.selectedCategory = category;
  }

  open(content) {
    this.modalService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
      this.closeResult = `Closed with: ${result}`;

      if (this.selectedCategory &&
        (!this.selectedCategory.children || this.selectedCategory.children && this.selectedCategory.children.length === 0)) {
        this.item.category_id = this.selectedCategory.id;
        this.item.category.name = this.selectedCategory.name;
      }

    }, (reason) => {
      this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
    });
  }

  save() {
    this.userService.setCurrentUser(this.user).subscribe();
    this.itemService.setMyItem(this.item).subscribe((item: Item) => {
      this.router.navigate(['/my/items/']);
      this.toastr.success('Сохранено.');
    });
  }

  ngOnInit(): void {
    this.userService.getCurrentUser().subscribe(user => {
      this.user = user;
    });

    this.cityService.getCities().subscribe(cities => {
      this.cities = cities;
    });

    this.route.params.subscribe(params => {
      if (params.id) {
        this.itemService.getMyItem(params.id).subscribe(item => {
          this.item = item;
        });
      }
    });


  }

}
