import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import {LoginComponent} from './login/login.component';
import {JwtModule} from '@auth0/angular-jwt';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {ErrorInterceptor} from './error.interceptor';
import {MainComponent} from './main/main.component';
import {MenuComponent} from './menu/menu.component';
import {NgxPaginationModule} from 'ngx-pagination';
import {IConfig, NgxMaskModule} from 'ngx-mask';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {ToastrModule} from 'ngx-toastr';
import {NgSelectModule} from '@ng-select/ng-select';
import {SidebarComponent} from './sidebar/sidebar.component';
import {MyComponent} from './my/my.component';
import {ServicesComponent} from './my/services/services.component';
import {SettingsComponent} from './my/settings/settings.component';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {TreeModule} from 'angular-tree-component';
import {CategorySelectorComponent} from './category-selector/category-selector.component';
import {AngularConfirmModalModule} from 'angular-confirm-modal';
import {ItemsComponent} from './items/index/items.component';
import {ItemComponent} from './items/show/item.component';
import {ItemComponent as MyItemShow} from './my/items/show/item.component';
import {ItemsComponent as MyItemsIndex} from './my/items/index/items.component';
import {ItemComponent as MyItemEdit} from './my/items/edit/item.component';
import {StatusNamePipe as ItemStatusNamePipe} from './items/status-name.pipe';
import {NotificationsComponent} from './my/notifications/notifications.component';
import {TruncatePipe} from "./pipes/truncate.pipe";
import { AutologinComponent } from './autologin/autologin.component';

export function tokenGetter() {
  return localStorage.getItem('access_token');
}

export const options: Partial<IConfig> | (() => Partial<IConfig>) = {};

@NgModule({
  declarations: [
    AppComponent,
    ItemsComponent,
    LoginComponent,
    MainComponent,
    MenuComponent,
    ItemComponent,
    SidebarComponent,
    MyComponent,
    MyItemShow,
    MyItemsIndex,
    MyItemEdit,
    ServicesComponent,
    SettingsComponent,
    CategorySelectorComponent,
    ItemStatusNamePipe,
    TruncatePipe,
    NotificationsComponent,
    AutologinComponent,
  ],
  imports: [
    BrowserModule,
    TreeModule.forRoot(),
    NgbModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    NgxPaginationModule,
    BrowserAnimationsModule,
    NgSelectModule,
    ToastrModule.forRoot(),
    NgxMaskModule.forRoot(options),
    AngularConfirmModalModule.forRoot({}),
    JwtModule.forRoot({
      config: {
        tokenGetter,
        whitelistedDomains: ['example.com'],
        blacklistedRoutes: ['example.com/examplebadroute/']
      }
    })
  ],
  providers: [
    {provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true},
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
}
