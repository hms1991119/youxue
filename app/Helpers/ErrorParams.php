<?php
/**
 * 错误提示，错误代码
 * @author hms
 *
 */
class ErrorParams{
    const ERRNO_SUCCESS = 200;
    const ERRNO_UPLOAD_FAILED = 201;
    const ERRNO_OLD_PASSWORD_ERROR = 202;
    const ERRNO_CAN_NOT_DEL_SELF = 203;
    const ERRNO_CAN_NOT_DEL_ADMIN =204;
    const ERRNO_LOGIN_INVALID = 205;
    const ERRNO_SERVER = 500;
    
    
    
    const ERRMSG_SUCCESS = '成功';
    const ERRMSG_UPLOAD_FAILED = '上传文件失败';
    const ERRMSG_OLD_PASSWORD_ERROR = '旧密码错误';
    const ERRMSG_CAN_NOT_DEL_SELF = '自己不能删除自己';
    const ERRMSG_CAN_NOT_DEL_ADMIN = '管理员无法删除';
    const ERRMSG_LOGIN_INVALID = '登录失效，请重新登录';
    const ERRMSG_SERVER = '服务器内部错误';
    
    //仅有提示语
    const ERRMSG_WRONG_USERNAME_OR_PASSWORD = '账号或密码错误';
    
    
}