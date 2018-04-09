import  {  Component,  ChangeDetectorRef  }  from  '@angular/core';
import  {  IonicPage,  NavController,  Platform /*,  NavParams*/  }  from  'ionic-angular';
import  {  FormBuilder,  FormGroup,  Validators,  AbstractControl  }  from  '@angular/forms';
import  {  SplashScreen  }  from  '@ionic-native/splash-screen';
//import  {  StatusBar  }  from  '@ionic-native/status-bar';
//import  {  Keyboard  }  from  '@ionic-native/keyboard';

import  {  RestProvider  }  from   '../../providers/rest/rest';

import  {  HomePage  } from  '../home/home';
import  {  MyProfilePage  }  from  '../my_profile/my_profile';
import  {  RegisterPage  }  from  '../register/register';

import  {  Utils  }  from  '../../app/utils';

/**
 * Generated class for the LoginPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})

export class LoginPage {

  private  paginas:  any =  {  "HomePage":  HomePage,  'MyProfilePage':  MyProfilePage};

  public  loginForm:  FormGroup;
  public  email:  AbstractControl;
  public  password:  AbstractControl;
  public  usuarioLogin:  any  =  {  email: '',  password: ''};
  public  usuario:  any  =  {};
  public  classStyles:  any;


  constructor(  private  navCtrl:  NavController,
                private  restProvider: RestProvider,
                private  formBuilder:  FormBuilder,
                private  utils:  Utils,
                private  chRef:  ChangeDetectorRef,
                //private  keyboard:  Keyboard,
                //private  navParams:  NavParams,
                //private  statusBar:  StatusBar,
                private  splashScreen:  SplashScreen,
                private  platform:  Platform  )  {
    this.classStyles  =  this.utils.classStyles;

    this.loginForm  = this.formBuilder.group({
      email: [ '', Validators.compose([  Validators.required,  Validators.minLength(5),  Validators.maxLength(30), Validators.email])],
      password: [ '', Validators.compose([  Validators.required,  Validators.minLength(5),  Validators.maxLength(30)])]
    });

    this.email = this.loginForm.controls['email'];
    this.password = this.loginForm.controls['password'];

//    this.keyboard.disableScroll(  false);
  };

  ngAfterViewInit()  {
    this.platform.ready().then(  () => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      //this.statusBar.backgroundColorByHexString(  '#203647');
      this.splashScreen.hide();
    });
  };

  ionViewDidLoad()  {
    if( this.utils.consultarStorage(  this.utils.llavesStorage.usuario)) {
      this.chRef.reattach();
      this.usuario = this.utils.consultarStorage(  this.utils.llavesStorage.usuario);
      this.loadScreen();
    }
  };


  doLogin()  {
    this.restProvider.loginUsuario(  this.usuarioLogin).subscribe(
      (  loginResponse) => {
        this.obtenerMiPerfil(  loginResponse);
      },
      (  error) =>  {
        this.utils.delegarAlertaDeRespuestaErronea(  error);
      }
    );
  };

  goToRegister()  {
    this.splashScreen.show();
    this.navCtrl.setRoot(  RegisterPage);
  };

  private obtenerMiPerfil(  data) {
    this.restProvider.miPerfil(  data.access_token).subscribe(
      (  miPerfilResponse) => {
        //this.utils.launchNotification(  miPerfilResponse);
        this.guardarMiPerfil(  miPerfilResponse,  data.access_token);
      },
      ( error) =>  {
        this.utils.delegarAlertaDeRespuestaErronea(  error);
      }
    );
  };

  private guardarMiPerfil(  data, token)  {
    if (data  =  data.respuesta) {
      this.usuario.actividades  =  data.actividades;
      this.usuario.apellido_paterno  =  data.apellido_paterno;
      this.usuario.apodo  =  data.apodo;
      this.usuario.archivos  =  data.archivos;
      this.usuario.ciudad  =  data.ciudad;
      this.usuario.descripcion  =  data.descripcion;
      this.usuario.email  =  data.email;
      this.usuario.estado  =  data.estado;
      this.usuario.estatus  =  data.estatus;
      this.usuario.fecha_de_actualizacion  =  data.fecha_de_actualizacion;
      this.usuario.fecha_de_creacion  =  data.fecha_de_creacion;
      this.usuario.fecha_de_nacimiento  =  data.fecha_de_nacimiento;
      this.usuario.genero  =  data.genero;
      this.usuario.id  =  data.id;
      this.usuario.imagen_de_perfil  =  data.imagen_de_perfil;
      this.usuario.institucion  =  data.institucion;
      this.usuario.nombre  =  data.nombre;
      this.usuario.pais  =  data.pais;
      this.usuario.pesos  =  data.pesos;
      this.usuario.tallas  =  data.tallas;
      this.usuario.telefono  =  data.telefono;
      this.usuario.telefono_movil  =  data.telefono_movil;
      this.usuario.tipo  =  data.tipo;

      
      this.utils.guardarEnStorage(  this.utils.llavesStorage.usuario,  this.usuario);
      this.utils.cargarMenu( this.usuario.tipo.id);
      this.loadScreen();  
    }
  };

  private loadScreen()  {
    this.navCtrl.setRoot( this.utils.delegarPaginaDeInicio(  this.paginas,  this.usuario),    {  'usuario':  this.usuario});
  };

}
