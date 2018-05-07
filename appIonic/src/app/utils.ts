import  {  MenuController,  AlertController ,  Platform  }  from  'ionic-angular';
//import  {  Badge  }  from  '@ionic-native/badge';
//import  {  Push  } from  '@ionic-native/push';
//import  {  FCM  }  from  '@ionic-native/fcm';
//import  {  RestProvider  }  from  '../providers/rest/rest';
import  {  Injectable  }  from  '@angular/core';

declare global {
  interface String {
    replaceAll(  search:  string,  replacement:  string):  string;
  }
}

@Injectable()

export  class  Utils  {
  public  llavesStorage:  any  =  {
    usuario:  'dataUsuario',
    pre_registro:  'preRegistro'
  };

  public  classStyles: any  =  {  classButton:  "button-web"};

  constructor(  //private  restProvider:  RestProvider,
                //private  fcm:  FCM,
                //private  badge:  Badge,
                //private  push:  Push,
                private  menuCtrl:  MenuController,
                private  platform:  Platform,
                private  alertCtrl:  AlertController) {

    if (  this.platform.is('cordova'))  {
      this.classStyles.classButton  =  "button-mobile";
    };

    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };

  };

  guardarEnStorage(  key:string,  data: any)  {
    localStorage.setItem(  key,  JSON.stringify( data));
    return  true;
  };

  consultarStorage(  key:string)  {
    if(  localStorage.getItem(  key))
      return  JSON.parse(  localStorage.getItem(  key));
    else
      return  false;
  };

  mostrarAlerta(  title:  string, subTitle: string) {
    let alert = this.alertCtrl.create({
      title: title,
      subTitle: subTitle,
      buttons: ['Ok']
    });
    alert.present();
  }

  parsearHorasServidor(  hora:  string)  {
    let horaObj  =  hora.split(':');
    let hh   =  (  '0'  +  horaObj[0]).slice(  -2);
    let mm   =  (  '0'  +  horaObj[1]).slice(  -2);

    return  hh + ':' + mm;
  };

  cargarMenu(  tipo_usuario: number  = null) {
    tipo_usuario  = tipo_usuario  ||  this.consultarStorage(  this.llavesStorage.usuario).tipo_usuario_id;
    let menuList  : any = this.menuCtrl.getMenus();
    for (let menuItem in menuList) {
      let enableStatus:boolean  = false;
      
      if (  menuList[menuItem].id ==  ('menu' + tipo_usuario))
        enableStatus  = true;

      this.menuCtrl.enable( enableStatus, menuList[menuItem].id);
    };
  };

  obtenerValorDeCatalogo(  catalogo,  selected,  valor  =  'tipo')  {
    for(  let  indexCatalogo  in  catalogo)  {
      if (  catalogo[  indexCatalogo].id  ==  selected)
        return  catalogo[  indexCatalogo][valor];
    }
  }

  delegarPaginaDeInicio(  paginas,  usuario: any = null) {
    usuario  = usuario  ||  this.consultarStorage(  this.llavesStorage);
    let tipo_usuario  =  usuario.tipo  ?  usuario.tipo.id  :  false;
    switch(  tipo_usuario)  {
      case  1:
      case  2:
          //this.launchNotification(  usuario);
          this.cargarMenu(  tipo_usuario);
          return  paginas.HomePage;
      case  3:
          //this.launchNotification(  usuario);
          this.cargarMenu(  tipo_usuario);
          return  paginas.HomePage;
      default:
          //this.removeNotification();
          return  paginas.LoginPage;
    }
  };

  delegarAlertaDeRespuestaErronea(  objetoDeError)  {
    let  titulo  =  "Error no identificado";
    let  mensaje  =  "Error con la aplicación no identificado... estamos trabajando para solucionarlo";

    if (  401 == objetoDeError.code) {
      titulo  =  "Error de autorización";
      mensaje  =  "Email o Password incorrectas. Por favor verfica tus datos";
    };

    if (  500  == objetoDeError.code) {
      titulo  =  "Error de aplicación";
      mensaje  =  objetoDeError.respuesta.mensaje;
    };

    this.mostrarAlerta(  titulo,  mensaje);
  };
}