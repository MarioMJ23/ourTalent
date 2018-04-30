import  {  HttpClient,  HttpHeaders }  from  '@angular/common/http';
import  {  Injectable  }  from  '@angular/core';
import  {  LoadingController  }  from  'ionic-angular';

import  { Observable  } from  'rxjs/Observable';
import  'rxjs/add/operator/catch';
import  'rxjs/add/observable/throw';
import  'rxjs/add/operator/map';
import  'rxjs/add/operator/finally';


/*
  Generated class for the RestProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class RestProvider {
  private  miLoading:  any;
  private  apiUrl:  any;
  private  apiGrant_type:   any;
  private  apiClient_id:  any;
  private  apiClient_secret:  any;
  private  token:  any  = null;

  private  serviciosActivos:  number  =  0;

  constructor(  private http: HttpClient,
                private  loadingCtrl:  LoadingController) {
//    Accesos para la API en virtualHost Local

    this.apiUrl = "http://ourtalent.local.proof:81/api";
    this.apiGrant_type  = "password";
    this.apiClient_id = "3";
    this.apiClient_secret = "fZm5WsuVxzsclKnSxX1BfUizB9JWGPJ4QrTdIljy";


//    Accesos para la API de Amazon Web Services


//    this.apiUrl = "http://findourtalent/api";
//    this.apiGrant_type  = "password";
//    this.apiClient_id = "3";
//    this.apiClient_secret = "ro0tTXWfp6TWGtUzW9al6ZI1qOPwEmoF0M7yxRSY";  

  }

  miMenu(): Observable<String[]>  {
    this.mostrarLoading();
    let serviceUrl  = 'assets/data/menu.json';
    let headerObject  = new HttpHeaders().set(  'Content-Type', 'application/json');
    let headersService  = { headers:  headerObject};

    return this.http.get( serviceUrl).map(  this.extraertData, headersService).finally(  ()  =>  {  this.esconderLoading()}).catch(  this.delegarError);
  };

  loginUsuario(  data): Observable<Object[]> {
    this.mostrarLoading();
    let serviceUrl  = this.apiUrl + '/oauth/token';
    let params  = JSON.stringify( {
          "grant_type"  :   this.apiGrant_type,
          "client_id"  :   this.apiClient_id,
          "client_secret"  :  this.apiClient_secret,
          "username"  :  data.email,
          "password"  :  data.password
        });
    let headerObject  = new HttpHeaders().set(  'Content-Type', 'application/json');
    let headersService  =  {  headers:  headerObject};
    return  this.http.post( serviceUrl, params, headersService).map(  this.extraertData).finally(  ()  =>  {  this.esconderLoading()}).catch(  this.delegarError);
  };

  actividades(): Observable<Object[]>  {
    this.mostrarLoading();
    let serviceUrl  = this.apiUrl + '/actividades';
    let headerObject  = new HttpHeaders()
            .set( 'Authorization',  'Bearer ' +  this.obtenerToken())
            .set( 'Content-Type', 'application/json');
    let headersService  =  {  headers:  headerObject};
    return  this.http.get(  serviceUrl, headersService).map(  this.extraertData).finally(  ()  =>  {  this.esconderLoading()}).catch(  this.delegarError);
  };

  tiposDeUsuario(): Observable<Object[]>  {
    this.mostrarLoading();
    let serviceUrl  = this.apiUrl + '/tipos_de_usuario';
    let headerObject  = new HttpHeaders()
            .set( 'Authorization',  'Bearer ' +  this.obtenerToken())
            .set( 'Content-Type', 'application/json');
    let headersService  =  {  headers:  headerObject};
    return  this.http.get(  serviceUrl, headersService).map(  this.extraertData).finally(  ()  =>  {  this.esconderLoading()}).catch(  this.delegarError);
  };

  informacionRegistrar(): Observable<Object[]>  {
    this.mostrarLoading();
    let serviceUrl  = this.apiUrl + '/informacion_registrar';
    let headerObject  = new HttpHeaders()
            .set( 'Content-Type', 'application/json');
//            .set( 'Authorization',  'Bearer ' +  token)
    let headersService  =  {  headers:  headerObject};
    return  this.http.get(  serviceUrl, headersService).map(  this.extraertData).finally(  ()  =>  {  this.esconderLoading()}).catch(  this.delegarError);
  };

  obtenerEstadosPorPais(  pais): Observable<Object[]>  {
    this.mostrarLoading();
    let serviceUrl  = this.apiUrl + '/estados/pais/' + pais;
    let headerObject  = new HttpHeaders()
            .set( 'Content-Type', 'application/json');
//            .set( 'Authorization',  'Bearer ' +  token)
    let headersService  =  {  headers:  headerObject};
    return  this.http.get(  serviceUrl, headersService).map(  this.extraertData).finally(  ()  =>  {  this.esconderLoading()}).catch(  this.delegarError);
  };

  obtenerCiudadesPorEstado(  estado):  Observable<Object[]> {
    this.mostrarLoading();
    let serviceUrl  = this.apiUrl + '/ciudades/estado/' + estado;
    let headerObject  = new HttpHeaders()
            .set( 'Content-Type', 'application/json');
//            .set( 'Authorization',  'Bearer ' +  token)
    let headersService  =  {  headers:  headerObject};
    return  this.http.get(  serviceUrl, headersService).map(  this.extraertData).finally(  ()  =>  {  this.esconderLoading()}).catch(  this.delegarError);
  }

  miPerfil(  token): Observable<Object[]>  {
    this.mostrarLoading();
    let serviceUrl  = this.apiUrl + '/usuarios/miperfil';
    let headerObject  = new HttpHeaders()
            .set( 'Authorization',  'Bearer ' +  token)
            .set( 'Content-Type', 'application/json');
    let headersService  =  {  headers:  headerObject};
    return  this.http.get(  serviceUrl, headersService).map(  this.extraertData).finally(  ()  =>  {  this.esconderLoading()}).catch(  this.delegarError);
  };

/*guardarTokenNotification(  tokenNotification:  string,  email: string):  Observable<Object[]>    {
    let  params  = JSON.stringify( { "notificacion":  tokenNotification});
    let  serviceUrl: string  = this.apiUrl  +  '/users/admin/notificationsUpdate/'  +  email;
    let  headerObject  =  new  HttpHeaders()
      .set( 'Authorization',  'Bearer '  +  this.obtenerToken())
      .set( 'Content-Type',  'application/json');
    let headersService  = {  headers:  headerObject};
    return  this.http.put(  serviceUrl,  params,  headersService).map(  this.extractData).catch(  this.handleError);
  };  */

  /*
  logout(): Observable<Object[]>  {
    this.getUserId();
    let serviceUrl  = this.apiUrl + "/users/" + this.userId + "/resend";
    let headerObject  = new HttpHeaders()
      .set( 'Authorization',  'Bearer ' + this.obtenerToken())
            .set( 'Content-Type', 'application/json');
        let headersService  = { headers:  headerObject};
        return
  };
  */
  private obtenerToken()  {
    let  dataUsuario  =  JSON.parse(  localStorage.getItem(  'dataUsuario'));

    if (  dataUsuario)
      this.token  = dataUsuario.token;

    return  this.token;
  };

  private extraertData(res: Response) {
    let body = res;
    return body || { };
  };

  private delegarError(  error: Response | any) {
    let errMsg  =  {  respuesta:  null,  code:  null};
    errMsg.respuesta  =  error.error;
    errMsg.code  =  error.status;
    return Observable.throw(errMsg);
  };

  private  mostrarLoading()  {
    if (  this.serviciosActivos  == 0)  {
      this.miLoading = this.loadingCtrl.create({
        spinner:  'hide',
        content:  '<div class="mi-loading">' +
                    '<div class="mi-spinner-box"></div>' +
                    'Cargando información ...' +
                  '</div>'
      });

      this.miLoading.present();
    }

    this.serviciosActivos++;
  }

  private  esconderLoading()  {
    this.serviciosActivos--;
    if (  this.serviciosActivos <= 0)
      setTimeout(() => {
        this.miLoading.dismiss();
      }, 500);
  }
}
