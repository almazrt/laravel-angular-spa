import {Component, OnInit} from '@angular/core';
import {Item} from '../../../items/item';
import {ItemService} from '../../../items/item.service';

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

  constructor(
    private itemService: ItemService) {
  }

  deleteItem(id: number) {
    this.itemService.deleteMyItem(id).subscribe(res => {
      this.loadItems();
    });
  }

  loadItems(status = null) {
    this.itemService.getMyItems(null).subscribe((data: any) => {
      this.items = data;
    });
  }

  ngOnInit() {
    this.loadItems(null);
  }

}
