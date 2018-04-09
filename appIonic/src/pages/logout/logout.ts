import  {  Component  }  from '@angular/core';
import  {  IonicPage,  NavController,  LoadingController  /*, NavParams*/  }  from 'ionic-angular';

import  {  LoginPage  }  from  '../login/login';
import  {  Utils  }  from  '../../app/utils';

/**
 * Generated class for the LogoutPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-logout',
  templateUrl: 'logout.html',
})
export class LogoutPage {

  constructor(  private  navCtrl:  NavController,
                private  loadingCtrl:  LoadingController,
                private  utils:  Utils  ) {
  }

  ionViewDidLoad() {
    this.setLoading();
  }

  setLoading() {
    let loading = this.loadingCtrl.create({
      spinner: 'bubbles',
      content: 'Cerrando sessión ...'
    });

    loading.present();

    setTimeout(() => {
      // this.utils.removeNotification();
      localStorage.clear();

      for (let llave  in   this.utils.llavesStorage) {
        localStorage.removeItem( this.utils.llavesStorage[  llave]);
      };
      setTimeout(() => {
        this.navCtrl.setRoot( LoginPage);
      }, 200);      
    }, 700);

    setTimeout(() => {
      loading.dismiss();
    }, 1000);
  }

}
