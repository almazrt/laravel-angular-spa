import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Category} from '../categories/category';
import {ITreeOptions, ITreeState, KEYS, TREE_ACTIONS} from 'angular-tree-component';
import {CategoryService} from '../categories/category.service';
import {ModalDismissReasons, NgbActiveModal, NgbModal} from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-category-selector',
  templateUrl: './category-selector.component.html',
  styleUrls: ['./category-selector.component.scss']
})
export class CategorySelectorComponent implements OnInit {
  categories: Category[] = [];
  state: ITreeState;

  @Input() category: Category = new Category();
  @Output() selectedCategory = new EventEmitter<Category>();

  options: ITreeOptions = {
    actionMapping: {
      mouse: {
        dblClick: (tree, node, $event) => (node.hasChildren) ? TREE_ACTIONS.TOGGLE_EXPANDED(tree, node, $event) : null,
        keys: {
          [KEYS.ENTER]: (tree, node, $event) => {
            node.expandAll();
          }
        }
      },
    }
  };

  constructor(
    private categoryService: CategoryService,
  ) {
  }

  onFocus(event) {
    this.selectedCategory.emit(event.node.data);
  }

  ngOnInit(): void {
    this.categoryService.getCategories().subscribe(categories => {
      this.categories = categories;
    });
  }

}
