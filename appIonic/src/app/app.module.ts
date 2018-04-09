import  {  BrowserModule  }  from  '@angular/platform-browser';
import  {  ErrorHandler,  NgModule } from '@angular/core';
import  {  IonicApp,  IonicErrorHandler, IonicModule } from 'ionic-angular';
import  {  SplashScreen  }  from '@ionic-native/splash-screen';
import  {  StatusBar  }  from  '@ionic-native/status-bar';
import  {  HttpClientModule  } from  '@angular/common/http';
import  {  Keyboard  }  from  '@ionic-native/keyboard';
import  {  FormsModule,  ReactiveFormsModule } from  '@angular/forms';

import  {  MyApp  }  from  './app.component';
import  {  Utils  }  from  './utils';

import  {  HomePage  }  from  '../pages/home/home';
import  {  LoginPage  }  from  '../pages/login/login';
import  {  MyProfilePage  }  from  '../pages/my_profile/my_profile';
import  {  RegisterPage  }  from  '../pages/register/register';

import  {  LogoutPage  }  from  '../pages/logout/logout';

import  {  RestProvider  }  from  '../providers/rest/rest';

/*
import  {  Push  }  from   '@ionic-native/push';
import  {  FCM  }  from   '@ionic-native/fcm';
import  {  Badge  }  from  '@ionic-native/badge';
*/



@NgModule({
  declarations: [
    MyApp,
    HomePage,
    LoginPage,
    MyProfilePage,
    LogoutPage,
    RegisterPage
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    LoginPage,
    MyProfilePage,
    LogoutPage,
    RegisterPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler},
    RestProvider,
    Utils,
    Keyboard,
/*  
    Badge,
    Push,
    FCM
*/
  ]
})
export class AppModule {}
