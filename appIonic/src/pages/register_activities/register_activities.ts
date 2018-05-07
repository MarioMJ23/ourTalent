import  {  Component,  ChangeDetectorRef  }  from  '@angular/core';
import  {  IonicPage,  NavController,  Platform ,  NavParams  }  from  'ionic-angular';
/*import  {  FormBuilder,  FormGroup,  Validators,  AbstractControl  }  from  '@angular/forms';*/
import  {  StatusBar  }  from  '@ionic-native/status-bar';

import  {  RestProvider  }  from   '../../providers/rest/rest';

import  {  HomePage  } from  '../home/home';
import  {  MyProfilePage  }  from  '../my_profile/my_profile';
import  {  LoginPage  }  from  '../login/login';
import  {  RegisterPage  }  from  '../register/register';


import  {  Utils  }  from  '../../app/utils';

/**
 * Generated class for the RegisterActivitiesPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-register-activities',
  templateUrl: 'register_activities.html',
})
export class RegisterActivitiesPage {

  private  paginas:  any =  { "LoginPage":  LoginPage,
                              "HomePage":  HomePage,
                              "MyProfilePage":  MyProfilePage,
                              "RegisterPage":  RegisterPage};

  public  nuevoUsuario:  any  =  {
    tipo_de_usuario_id:  null,
    email:  null,
    password:  null,
    confirmarPassword:  null,
    telefono:  null,
    actividades:  {

    },
    institucion:  {
      nombre:  null,
      tipo_de_institucion_id:  null,
      nombre_corto:  null
    },
    nombre:  null,
    tipo_de_sangre_id:  null,
    genero:  null,
    fecha_de_nacimiento:  null,
    apellido_paterno:  null,
    apellido_materno:  null,
    pais_id: null,
    estado_id: null,
    ciudad_id: null,
  };

  public  classStyles:  any;

  public  catalogoDeActividades:  any;

  constructor(  public  utils:  Utils,
                private  navCtrl:  NavController,
                private  navParams:  NavParams,
                private  restProvider: RestProvider,
                /*private  formBuilder:  FormBuilder,*/
                private  statusBar:  StatusBar,
                private  platform:  Platform,
                private  chRef:  ChangeDetectorRef  ) {
    this.classStyles  =  this.utils.classStyles;

    this.platform.ready().then(  ()  =>  {
      this.statusBar.backgroundColorByHexString(  '#ffffff');
    });
  }

  ngOnInit() {
    this.nuevoUsuario  =  this.navParams.get(  'nuevoUsuario');
    this.catalogoDeActividades  =  this.navParams.get(  'catalogoDeActividades');
    console.log(  this.catalogoDeActividades);
  }


  ionViewDidLoad() {
    console.log('ionViewDidLoad RegisterActivitiesPage');
  }

}
