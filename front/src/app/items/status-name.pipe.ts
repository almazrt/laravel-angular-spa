import {Pipe, PipeTransform} from '@angular/core';
import {ITEM_STATUSES} from './item';

@Pipe({name: 'statusName'})
export class StatusNamePipe implements PipeTransform {
  transform(status: number): string {
    return Object.values(ITEM_STATUSES).find(s => s.value === status).title;
  }
}
