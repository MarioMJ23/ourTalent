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
    pais_id:  [  null, Validators.compose(  [  Validators.required])],
    estado_id:  [  null, Validators.compose(  [  Validators.minLength(1)])],
    ciudad_id:  [  null, Validators.compose([  Validators.minLength(1)])]
  };

  private  validacionesUsuario:  any  =  {
    nombre:  [  '',  Validators.compose(  [  Validators.required,  Validators.minLength(5),  Validators.maxLength(30)])],
    apellido_paterno:  [  '',  Validators.compose(  [  Validators.required,  Validators.minLength(5),  Validators.maxLength(30)])],
    apellido_materno:  [  '',  Validators.compose(  [  Validators.required,  Validators.minLength(5),  Validators.maxLength(30)])],
    tipo_de_sangre_id:  [  '',  Validators.compose(  [  Validators.required])],
    fecha_de_nacimiento:  [  '',  Validators.compose(  [  Validators.required])],
    genero:  [  '',  Validators.compose(  [  Validators.required])],
    apodo:  [  '',  Validators.compose(  [Validators.minLength(5),  Validators.maxLength(15)])]
  };

  private  validacionesInstitucion:  any  =  {
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
  public  nombre_corto:  AbstractControl;
  public  tipo_de_institucion_id:  AbstractControl;
  public  nombre:  AbstractControl;
  public  apellido_paterno:  AbstractControl;
  public  apellido_materno:  AbstractControl;
  public  tipo_de_sangre_id:  AbstractControl;
  public  fecha_de_nacimiento:  AbstractControl;
  public  pais_id:  AbstractControl;
  public  estado_id:  AbstractControl;
  public  ciudad_id:  AbstractControl;
  public  genero:  AbstractControl;

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

  public  usuario:  any  =  {};
  public  classStyles:  any;

  public  catalogoDeActividades:  any;
  public  catalogoDeTiposDeUsuario:  any;
  public  catalogoDeTiposDeSangre:  any;
  public  catalogoDeTiposDeInstitucion:  any;
  public  catalogoDePaises:  any;
  public  catalogoDeEstados:  any;
  public  catalogoDeCiudades:  any;

  public  datePickerConfig: any = { 
                  fecha_de_nacimiento:  { min:  '', max:  ''},
                  displayFormat:  'DD-MM-YYYY',
                  pickerFormat: 'DD/MM/YYYY'  };

  constructor(  private  navCtrl:  NavController,
                private  restProvider: RestProvider,
                private  formBuilder:  FormBuilder,
                public  utils:  Utils,
                private  statusBar:  StatusBar,
                private  splashScreen:  SplashScreen,
                private  platform:  Platform,
                private  chRef:  ChangeDetectorRef  ) {
    this.classStyles  =  this.utils.classStyles;
    this.initFormularioGeneral();
    this.obtenerCatalogos();

    /* Establecer configuración de DatePicker */
    let today = new Date();
    let year  = (today.toISOString()).split('-')[0];
    //today.setDate(  today.getDate() - (364 * 4));
    let fecha_minima_para_usuarios = today.toISOString().replace(  year, (parseInt(  year) - 4).toString());
    this.datePickerConfig.fecha_de_nacimiento.max = fecha_minima_para_usuarios;
    this.datePickerConfig.fecha_de_nacimiento.min  = this.datePickerConfig.fecha_de_nacimiento.max.replace(  (  parseInt( year) - 4), (parseInt(year) - 30));
    this.platform.ready().then(  ()  =>  {
      this.statusBar.backgroundColorByHexString(  '#c0c0c0');
      this.splashScreen.show();
    });
  }

  ngBeforeViewInit()  {
  }

  ngAfterViewInit()  {
    this.platform.ready().then(  () => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      this.splashScreen.hide();
    });
  };

  ionViewDidLoad() {
//    console.log('ionViewDidLoad RegisterPage');
  }

  irLogin()  {
    this.navCtrl.setRoot(  LoginPage);
  };

  segmentChanged(  obj) {
    this.chRef.reattach();
    this.nuevoUsuario.tipo_de_usuario_id  =  obj.id;
  };

  tipoDeUsuarioSeleccionado(  tipo  =  3)  {    
    if (  this.nuevoUsuario.tipo_de_usuario_id  ==  tipo)
      return  'activated segment-selected';
    else
      return  '';
  }

  actualizarEstados()  {
    this.nuevoUsuario.pais_id  =  null;

    if (  this.nuevoUsuario.pais_id)
      this.restProvider.obtenerEstadosPorPais(  this.nuevoUsuario.pais_id).subscribe(
        (  respuesta)  =>  {
          this.procesarEstadosRespuesta(  respuesta);
        },
        (  error)  =>  {
          this.utils.delegarAlertaDeRespuestaErronea(  error);
        }
      );
  };


  actualizarCiudades()  {
    this.nuevoUsuario.estado_id  =  null;
    if (  this.nuevoUsuario.estado_id)
      this.restProvider.obtenerCiudadesPorEstado(  this.nuevoUsuario.estado_id).subscribe(
        (  respuesta)  =>  {
          this.procesarCiudadesRespuesta(  respuesta);
        },
        (  error)  =>  {
          this.utils.delegarAlertaDeRespuestaErronea(  error);
        }
      );
  };

  irSiguiente()  {
    console.log(  this.nuevoUsuario);
  }

  private  procesarEstadosRespuesta(  estadosObjeto)  {
    this.catalogoDeEstados  =  estadosObjeto.respuesta;
  };

  private  procesarCiudadesRespuesta(  ciudadesObjeto)  {
    this.catalogoDeCiudades  =  ciudadesObjeto.respuesta;
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
    this.catalogoDeTiposDeInstitucion  =  datosRespuesta.respuesta[  'tipos_de_institucion'];
    this.catalogoDePaises  =  datosRespuesta.respuesta[  'paises'];
    this.catalogoDeEstados  =  datosRespuesta.respuesta[  'estados'];
    this.catalogoDeCiudades  =  datosRespuesta.respuesta[  'ciudades'];
    this.initFormularioGeneral();
    this.initFormularioUsuario();
    this.initFormularioInstitucion();
    this.nuevoUsuario.tipo_de_usuario_id  =  3  //  abriendo el segment por default 
  };

  private  initFormularioGeneral()  {
    this.registerForm  =  this.formBuilder.group( this.validacionesGenerales);

    this.email = this.registerForm.controls['email'];
    this.password = this.registerForm.controls['password'];
    this.telefono = this.registerForm.controls['telefono'];
    this.tipo_de_usuario_id = this.registerForm.controls['tipo_de_usuario_id'];
    this.confirmarPassword = this.registerForm.controls['confirmarPassword'];
    this.pais_id  =  this.registerForm.controls[  'pais_id'];
    this.estado_id  =  this.registerForm.controls[  'estado_id'];
    this.ciudad_id  =  this.registerForm.controls[  'ciudad_id'];
  }

  private  initFormularioUsuario()  {
    this.usuarioForm  =  this.formBuilder.group(  this.validacionesUsuario);

    this.nombre  =  this.usuarioForm.controls[  'nombre'];
    this.apellido_paterno  =  this.usuarioForm.controls[  'apellido_paterno'];
    this.apellido_materno  =  this.usuarioForm.controls[  'apellido_materno'];
    this.fecha_de_nacimiento  =  this.usuarioForm.controls[  'fecha_de_nacimiento'];
    this.tipo_de_sangre_id  =  this.usuarioForm.controls[  'tipo_de_sangre_id'];
    this.genero  =  this.usuarioForm.controls[  'genero'];
  }

  private  initFormularioInstitucion()  {
    this.institucionForm  =  this.formBuilder.group(  this.validacionesInstitucion);

    this.institucion_nombre  =  this.institucionForm.controls[  'nombre'];
    this.nombre_corto  =  this.institucionForm.controls[  'nombre_corto'];
    this.tipo_de_institucion_id  =  this.institucionForm.controls[  'tipo_de_institucion_id'];
  }
}