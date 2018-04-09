import  {  Component,  ViewChild  }  from  '@angular/core';
import  {  Nav,  Platform  }  from  'ionic-angular';
import  {  StatusBar  }  from  '@ionic-native/status-bar';
//gimport  {  SplashScreen  }  from  '@ionic-native/splash-screen';

import  {  RestProvider  } from  '../providers/rest/rest';
import  {  Utils  }  from   './utils';

import  {  HomePage  } from  '../pages/home/home';
import  {  LoginPage  } from  '../pages/login/login';
import  {  MyProfilePage  }  from  '../pages/my_profile/my_profile';
import  {  LogoutPage  }  from  '../pages/logout/logout';

@Component({
  templateUrl: 'app.html'
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;

  rootPage:  any;
  catalogoDeMenus:  any;
  private paginas:  any;


  constructor(  private  platform:  Platform,
                private  statusBar:  StatusBar, 
//                private  splashScreen:  SplashScreen,
                private  restProvider: RestProvider,
                private  utils:  Utils) {

    this.restProvider.miMenu().subscribe(
      (  menuRespuesta) => {
        this.paginas =  {
          "HomePage":  HomePage,
          "LoginPage":  LoginPage,
          "MyProfilePage":  MyProfilePage,
          "LogoutPage":  LogoutPage
        };
        this.catalogoDeMenus =  menuRespuesta;
        this.initializarApp();
        this.rootPage = this.utils.delegarPaginaDeInicio(  this.paginas);
      },
      ( error) =>  {
        console.log(  error);
      }
    );

  };

  initializarApp()  {
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      // this.statusBar.styleDefault();
      // this.splashScreen.hide();
      this.statusBar.backgroundColorByHexString(  '#203647');
    });
  }

  abrirPagina(  pagina) {
    // Reset the content nav to have just this page
    // we wouldn't want the back button to show in this scenario
    this.nav.setRoot(  pagina);
  }

}

