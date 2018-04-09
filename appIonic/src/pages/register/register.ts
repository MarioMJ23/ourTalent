import  {  Component,  ChangeDetectorRef  }  from  '@angular/core';
import  {  IonicPage,  NavController,  Platform /*,  NavParams*/  }  from  'ionic-angular';
import  {  FormBuilder,  FormGroup,  Validators,  AbstractControl  }  from  '@angular/forms';
import  {  SplashScreen  }  from  '@ionic-native/splash-screen';
import  {  StatusBar  }  from  '@ionic-native/status-bar';
//import  {  Keyboard  }  from  '@ionic-native/keyboard';

import  {  RestProvider  }  from   '../../providers/rest/rest';

import  {  HomePage  } from  '../home/home';
import  {  MyProfilePage  }  from  '../my_profile/my_profile';
import  {  LoginPage  }  from  '../login/login';

import  {  Utils  }  from  '../../app/utils';

/**
 * Generated class for the RegisterPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-register',
  templateUrl: 'register.html',
})
export class RegisterPage {
  private  paginas:  any =  {  "HomePage":  HomePage,  'MyProfilePage':  MyProfilePage};
  private  validacionesGenerales:  any  =  {
    email: [ '', Validators.compose([  Validators.required,  Validators.minLength(5),  Validators.maxLength(30), Validators.email])],
    password: [ '', Validators.compose([  Validators.required,  Validators.minLength(5),  Validators.maxLength(30)])],
    confirmarPassword: [  '', Validators.compose([  Validators.required])],
    telefono:  [ '', Validators.compose([  Validators.required,  Validators.minLength(10),  Validators.maxLength(15)])],
    tipo_de_usuario_id:  [  3,  Validators.compose([Validators.required])],
  };

  private  validacionesUsuario:  any  =  {
    nombre:  [  '',  Validators.compose(  [  Validators.required,  Validators.minLength(5),  Validators.maxLength(30)])],
    apellido_paterno:  [  '',  Validators.compose(  [  Validators.required,  Validators.minLength(5),  Validators.maxLength(30)])],
    apellido_materno:  [  '',  Validators.compose(  [  Validators.required,  Validators.minLength(5),  Validators.maxLength(30)])],
    tipo_de_sangre_id:  [  '',  Validators.compose(  [  Validators.required])],
    apodo:  [  '',  Validators.compose(  [Validators.minLength(5),  Validators.maxLength(15)])]
  };

  private  validacionesInstituciones:  any  =  {
    nombre:  [  '',  Validators.compose(  [  Validators.required,  Validators.minLength(5),  Validators.maxLength(50)])],
    nombre_corto:  [  '',  Validators.compose(  [  Validators.required,  Validators.minLength(5),  Validators.maxLength(50)])],
    tipo_de_institucion_id:  [  '',  Validators.compose(  [  Validators.required])]
  };

  public  institucionForm:  FormGroup;
  public  usuarioForm:  FormGroup;
  public  registerForm:  FormGroup;

  public  email:  AbstractControl;
  public  password:  AbstractControl;
  public  confirmarPassword:  AbstractControl;
  public  telefono:  AbstractControl;
  public  actividades:  AbstractControl;
  public  tipo_de_usuario_id:  AbstractControl;
  public  institucion_nombre:  AbstractControl;
  public  institucion_nombre_corto:  AbstractControl;
  public  institucion_tipo:  AbstractControl;
  public  nombre:  AbstractControl;
  public  apellido_paterno:  AbstractControl;
  public  apellido_materno:  AbstractControl;
  public  tipo_de_sangre_id:  AbstractControl;
  public  fecha_de_nacimiento:  AbstractControl;
  public  genero:  AbstractControl;

  public  nuevoUsuario:  any  =  {
    tipo_de_usuario_id:  3,
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
    apellido_materno:  null
  };
  public  usuario:  any  =  {};
  public  classStyles:  any;
  public  catalogoDeActividades:  any;
  public  catalogoDeTiposDeUsuario:  any;
  public  catalogoDeTiposDeSangre:  any;
  public  catalogoDeTiposDeInstituciom:  any;

  constructor(  private  navCtrl:  NavController,
                private  restProvider: RestProvider,
                private  formBuilder:  FormBuilder,
                private  utils:  Utils,
                private  statusBar:  StatusBar,
                private  splashScreen:  SplashScreen,
                private  platform:  Platform,
                private  chRef:  ChangeDetectorRef  ) {
    this.classStyles  =  this.utils.classStyles;
    this.initFormularioGeneral();
    this.obtenerCatalogos();
  }

  ngBeforeViewInit()  {
    this.platform.ready().then(  ()  =>  {
      this.statusBar.backgroundColorByHexString(  '#c0c0c0');
      this.splashScreen.show();
    });
  }

  ngAfterViewInit()  {
    this.platform.ready().then(  () => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      //this.splashScreen.hide();
    });
  };

  ionViewDidLoad() {
//    console.log('ionViewDidLoad RegisterPage');
  }

  goToLogin()  {
    this.navCtrl.setRoot(  LoginPage);
  };

  segmentChanged(  obj) {
    this.chRef.reattach();
    this.nuevoUsuario.tipo_de_usuario_id  =  obj.id;
    console.log(  this.nuevoUsuario.tipo_de_usuario_id);
  }

  private  obtenerCatalogos()  {
    this.traerInformacionRegistrar();
  };

  private  traerInformacionRegistrar()  {
    this.restProvider.informacionRegistrar().subscribe(
      (  respuesta)  =>  {
        this.procesarRespuestaActividades(  respuesta);
      },
      (  error)  =>  {
        this.utils.delegarAlertaDeRespuestaErronea(  error);
      }
    );
  };

  private  procesarRespuestaActividades(  datosRespuesta:  any)  {
    this.catalogoDeActividades  =  datosRespuesta.respuesta[  'actividades'];
    this.catalogoDeTiposDeUsuario  =  datosRespuesta.respuesta[  'tipos_de_usuario'].reverse();
    this.catalogoDeTiposDeSangre  =  datosRespuesta.respuesta[  'tipos_de_sangre'];
    this.catalogoDeTiposDeInstituciom  =  datosRespuesta.respuesta[  'tipos_de_institucion'];
    this.initFormularioGeneral();
  };

  private  initFormularioGeneral()  {
    this.registerForm  =  this.formBuilder.group( this.validacionesGenerales);

    this.email = this.registerForm.controls['email'];
    this.password = this.registerForm.controls['password'];
    this.telefono = this.registerForm.controls['telefono'];
    this.tipo_de_usuario_id = this.registerForm.controls['tipo_de_usuario_id'];
    this.confirmarPassword = this.registerForm.controls['confirmarPassword'];
  }
}
