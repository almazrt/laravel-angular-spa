import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {AuthGuard} from './auth.guard';
import {LoginComponent} from './login/login.component';
import {ItemsComponent} from './items/index/items.component';
import {ItemComponent} from './items/show/item.component';
import {MyComponent} from './my/my.component';
import {ItemsComponent as MyItemsIndex} from './my/items/index/items.component';
import {ItemComponent as MyItemShow} from './my/items/show/item.component';
import {ItemComponent as MyItemEdit} from './my/items/edit/item.component';
import {ServicesComponent as MyServicesComponent} from './my/services/services.component';
import {SettingsComponent as MySettingsComponent} from './my/settings/settings.component';
import {NotificationsComponent} from './my/notifications/notifications.component';
import {AutologinComponent} from './autologin/autologin.component';

const routes: Routes = [
  {path: '', component: ItemsComponent},
  {path: 'city/:cityId', component: ItemsComponent},
  {path: 'category/:categoryId/city/:cityId', component: ItemsComponent},
  {path: 'category/:categoryId', component: ItemsComponent},
  {path: 'items/:id', component: ItemComponent},
  {path: 'login', component: LoginComponent},
  {path: 'autologin/:token/:url', component: AutologinComponent},
  {path: 'my', component: MyComponent, canActivate: [AuthGuard]},
  {path: 'my/items', component: MyItemsIndex, canActivate: [AuthGuard]},
  {path: 'my/items/new', component: MyItemEdit, canActivate: [AuthGuard]},
  {path: 'my/items/:id/edit', component: MyItemEdit, canActivate: [AuthGuard]},
  {path: 'my/items/:id', component: MyItemShow, canActivate: [AuthGuard]},
  {path: 'my/services', component: MyServicesComponent, canActivate: [AuthGuard]},
  {path: 'my/settings', component: MySettingsComponent, canActivate: [AuthGuard]},
  {path: 'my/notifications', component: NotificationsComponent, canActivate: [AuthGuard]},

  // otherwise redirect to home
  {path: '**', redirectTo: ''}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})

export class AppRoutingModule {
}
