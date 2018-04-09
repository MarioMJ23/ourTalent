import  {  Component  }  from  '@angular/core';
import  {  IonicPage,  NavController,  NavParams,  Platform  } from 'ionic-angular';
import  {  SplashScreen  }  from  '@ionic-native/splash-screen';

import  {  RestProvider  }  from   '../../providers/rest/rest';

import  {  Utils  }  from  '../../app/utils';


/**
 * Generated class for the HomePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-home',
  templateUrl: 'home.html',
})
export class HomePage {
  usuario:  any  =  {};

  constructor(  private  navCtrl:  NavController,
                private  restProvider: RestProvider,
                private  navParams:  NavParams,
                private  splashScreen:  SplashScreen,
                private  platform:  Platform,
                private  utils:  Utils  ) {
  };

  ionViewDidLoad() {
    console.log('ionViewDidLoad HomePage');
  };

  ngOnInit()  {
    if (  !(this.navParams.get(  'usuario')  && (this.usuario  =  this.navParams.get(  'usuario')))) {
      this.usuario  =  this.utils.consultarStorage(  this.utils.llavesStorage.usuario);
    };
  };

  ngAfterViewInit()  {
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      this.splashScreen.hide();
    });
  };

}
