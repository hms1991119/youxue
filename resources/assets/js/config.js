/**
 * Created by hms on 2020-08-18.
 */
/**
 * 公共配置，配置域名等信息
 */
var api_url = '';
var system_name = '保康社区';
console.log(process.env.NODE_ENV);


switch( process.env.NODE_ENV ){
    case 'development':
        api_url = 'http://192.168.1.109:7878/api/vue';
        break;
    case 'production':
        api_url = 'http://roast.demo.laravelacademy.org/api/v1';
        break;
}


export const ROAST_CONFIG = {
    API_URL: api_url,
    SYSTEM_NAME : system_name
}