<?php
if (pcclient()) {
    $config = array (
        //应用ID,您的APPID。
        //'app_id' => "2017062707581264",

        //沙箱环境
        'app_id' => "2016080600184608",

        //商户私钥
        //'merchant_private_key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDnNZDUulnZKO2ghjPrSgiMBafMl/MipAe4peVuxBgtcqer6HLDzHdUMvdeMiDyvQ3t83hdWgFZShEsPRIVJl5XnIrJOYsVh9Qe6MJ1FiA1cB+t3KDiMlDAYa19UE9qmeAtxZ2oXRsn2+cLliFPSGuel0dJPg2wvwSX/f9LgJrptnSWi82QHfPxg/8jIdjiXUdw1oOc4g8cAH7kGABMwRUSPehq1oqyF9wFgCwShjC6S9crxd8q08Q2g9SKU2Z7H97RJtK8u08WOMRZTBjQ0rY/tqllq2i0Xmdywvnf3i2XkpNO7sZK3ybNnjml1muV3HY0ABC7TX6uB5PoFj94DHz1AgMBAAECggEBAJwe+m36a0MMtPBIznQZaI4MH5MyI1YHxsLzGmph9SVzHy8gZaY6wXTUeV5coQznhalgVq1KYlDFh7UEg9pOLzQfm0NnHLhsIFrCttPTHeqXjHyc1vIGIarWCgztFsMXpl2h6+RNAlI21dtoA5QChdDvu44EXcA0K8jqFOIJtBEM/v1I2AM444Kp6SrcLQ0zMbuDQ5JhNdqcg7QnQrwQbBcLaqkhwba78ANx5mMr5XRMF8i/XXUCsq0j0FqIQZKQe28aM7fLh1xhJW3ZMOg/UqDWk/+mDrf4r+ExbkCqSCn77ACJF4lVkW1da3XkIMRd7p489g4odIadjAi4R81mxx0CgYEA/NA8jpi3dc+vWqelACM/VUj14sCQx4CahGebAtBLp3M6/dJeHi8JoyEeZsPIhsj617IvD6+kywJm4MzT5XKUF92kdyD3n8xnqxR9z3TFEpMFyn8T+g+YCoMoC/InskFnf0smhBjgGiJCZB0gaMza0cY/EBRr2wXdlktCUkdFQscCgYEA6h+eO0T7g4U/cFmaej9rVMdcpRvawcedu0+kzXmp5v3nfeZK4U59cc1LeIkXehO9QaZJzmWxDhCeqhuXjp+JsFWnB4w99asO70+P6jxSWPkV2O9oTONzvOcVC+TV7fmLomP6qAfRXgvUM7F/PcJys+zwEp6Ae8CKj3Lok161BmMCgYEA7jlextPbFFWWnCsazQ1psXil0ny4MHXbpGZoZ/dVQr3PWbwwWeri/ufHWPil7XRXAodx1ysgcveZb70y8qPMLsz5HBRhoh+flFMj1ifnSABoVY73iQvGrik2xELz6wG8f/OVoKY8DgQ4YVQc5QQcMc3IQOOtWl6llejm3tcvyaMCgYA57DSjiT+InHDDhQeY8xPE18Xt+2Q1yQMXEm89frowMeUR2uXvtBGJFDd1zMUIKNYL5e4gqDwTtLzsbQMkAAh6ndZDIck6fGWng1Ghq+bbqFRlZWWykBtUQv+L/8OFqtWHCaE77SM5V0faujE2wGLMbPRARwKWm14se0tbGnVC7QKBgF7ZwmZTDwX4GROrqIo7+5420yj54PrDtLTBdXq3lU0uMLNV0JHG4lWfMIsXZh6gzWl27YTa0I8DuFnwAYa3nnmpMT4PhrFtp2LuYDjDdKNVr8OJa0uGyvcvB5Gpq+Yw9YjEOvp5gsX8ARmM77vfI01+KiDDT9r95+BWnYa9z144",

        //沙箱环境
        'merchant_private_key' => "MIIEpQIBAAKCAQEA8vcl4Medr0mbHoGhOxZYc1OLLu5QhTTZpnxSIql9LZSIKB6/PpmNbibPSHE/UoNpN+M2DAOnGfCM7l2iT8zBxvRPulB/R9zvyY6iqCASQgU5cG+XtfsNDWOR5ftYMagbrhxGpwf3APoV6ou1sPytmhNLdcLkyh1MXn+8GaWfpnsJSu7fUpMWG0jHlv/ctGSYWloP3G3oWvsGcl/0DO6nfWbVqZEHf987I0k+cwi4BstsLB5N1TXWAS2Cfa617P7vW690JL2Lb56bnVF+GOpu6fatBa2MmnwWbcDoclWgxfEwbaqQWgbCLqwOU9XSee3no07PgwCjgLmpDTvzwU47iwIDAQABAoIBAQCjavhfJ+Q3chqTej0nsO/tIdQLzN77uYBrKlNUXQuFDNJHqeaYBE/MNu5Um1cr+Jdcr8Y6bnqGR/WCnhf99IqhdtHpTxtNCp19xCJDUs70+O6ZYXV5QVKWHtKTDWtUeu2jPgGHdyP71DnJeA7M7CcX6sJmgp/AEdS7+s5ZsbygC/HABliaTpMUTgOe+4+9wh5aHb48Fbyl5ETtefJypgi+aW727HXgLvHGlOcx+TdZy1mscwU+KhIhbJZ3EJcnfraV1z8vD1UkhkMOiW7b3xUmDVeDlovSWxbQEdPu4KIiJEas+9u101EPxtwY60q9IpW1C0f7c56AwjXO5sNCsZ+BAoGBAPxSFJN/Vn0Kjn+jKEi0Q2SDYiD83PY/rGt2cTlTNcuYxP6tcRgQABKg++BFLjpn7qClZsBBNp3IhIrc+VWEar5wBgQ2D1IZ8M/Ixxo3mg03PgCSt7t8eElR/0SgAESuNruru/8UN7ylTxYQ4tDL2iLCHCmmDUTP8A8YRNbdB9JHAoGBAPaCJPSRUDg5VAVYS6UjDrvOcT2dMmS0b+bMXO9ul4bX+26J23hsZ9XGvzXPoNMvJ5O6TtH2OC3XGXMxWNYvxPx8cmXz/FjQFXP9ubPa6hGR0ALccBsIC42rvDoqTdPCkxlQpTOY+r90mHa6xpGRMaxlmxwFTek2OCPwhmLOmIqdAoGAEpl+WM0XNAp2LKR7ULixCxTARAw/wYs6C4XknMQsgACX7OoeHxb22mixiHuxB68noQHwTBXCj+j7FD1rx8kGEVmyp9bQVE4DOV3kh2M34OeEk4g9MP3g5A6+UXG181ogQL9NEWWNIkPRS6AdCCUuxEcoyk0qRztIx+QTFv+eFvsCgYEA1tZ0GMYwkN+9z261drXIGHwCi31eNxBe2lpPwMi0vOutkRgKs7hfApxVdzN+aa+WIZTlLu4U5jaqUo+2ae12E8rt9NcgndK0b8O4vfxTtX5MOMIf3h8z2oPK5zKJY74Xb5+uavqvxn56hjef6awOC7794Pzqew8q/H+az7BYl60CgYEAnaePjNbNq0QQtWxdNgBg868KcL64OdfDE12RDqa0US2+Yd/7LZMN1xu19Le8LsWJCOwBfnvRPGcTypkrZF7ZQ5bn8CUseW741d4GfDiJp/JSFM2J4Gb8/n/o/5L/aBtOHKBITcuR/pmMrMkihROrW3prCEocrZ1RdyjgJAM6Gx0=",

        //异步通知地址
        'notify_url' => "http://www.cs0663.cn/notify.php",

        //同步跳转
        'return_url' => "http://www.cs0663.cn/pay.php?act=return&type=ant",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        //'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

        //沙箱环境
        'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        //'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1Bvq1CjlICx/tdZYHE98qFApl5XIdEaDB9lC+gKUnvQbe+9pQ0hqCqZKzfK3LORyM8Fck38xiImM/UtbqM9Ya3K5upqCs0Vzt3W7KDLTDRfLfDI4KTP9gf2FCT31YdQq61TL7m7nFamqq/k6UIH5yGcHrDcrLOLRnHRdidl+sOfCK+1kRtg/jiBqmOVhdXl4gnLZ1t6xjtsDAlcfPy2FKDbJ7eIHprganlfcvwjdIOBxDiFkwTGf4uVoUsOZwdjZilXhtqEcLQUFTe4IwAuZK0wuF990hBjsQxm57t3DWUxNY4mQEkHJDb2m/MbKIW2i464tCCNSQf6iSrtKBsH9nQIDAQAB",

        //沙箱环境
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyN9PxyOi/PUx3QrFUMyTTnZ/0d+5YN72T47JrH5UPeZ/U64XUZ3zKhjjZeKJRR9a8ooDGiXCSNfJhwEvPPPlCu2s2SEQR9WExQTVVdevGLKBhd+WlRznUIAUJrZ1a4WZShNf3z80dLgAH/OkDt5rzCOC4mfNBg/HaNr0jgvaszYnI5LJWdVugsIjM9xplUBItVfKMARh0FV0Ppb3SFoAA5bSl7dFR0ZzLo4qFUS9uXSULsIsiSht4tlbecjwb4SgebdAgAB0L8QKX40rQy9MvGPS1x8YGhUsh+shJlzwNFfCg2xN0YnwDInFEX6HEEGFoCJO7fvtHe1ELAFLIyJB6QIDAQAB",
    );
} else {
    $config = array (
        //应用ID,您的APPID。
        //'app_id' => "2017062707581264",

        //沙箱环境
        'app_id' => "2016080600184608",

        //商户私钥
        //'merchant_private_key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDnNZDUulnZKO2ghjPrSgiMBafMl/MipAe4peVuxBgtcqer6HLDzHdUMvdeMiDyvQ3t83hdWgFZShEsPRIVJl5XnIrJOYsVh9Qe6MJ1FiA1cB+t3KDiMlDAYa19UE9qmeAtxZ2oXRsn2+cLliFPSGuel0dJPg2wvwSX/f9LgJrptnSWi82QHfPxg/8jIdjiXUdw1oOc4g8cAH7kGABMwRUSPehq1oqyF9wFgCwShjC6S9crxd8q08Q2g9SKU2Z7H97RJtK8u08WOMRZTBjQ0rY/tqllq2i0Xmdywvnf3i2XkpNO7sZK3ybNnjml1muV3HY0ABC7TX6uB5PoFj94DHz1AgMBAAECggEBAJwe+m36a0MMtPBIznQZaI4MH5MyI1YHxsLzGmph9SVzHy8gZaY6wXTUeV5coQznhalgVq1KYlDFh7UEg9pOLzQfm0NnHLhsIFrCttPTHeqXjHyc1vIGIarWCgztFsMXpl2h6+RNAlI21dtoA5QChdDvu44EXcA0K8jqFOIJtBEM/v1I2AM444Kp6SrcLQ0zMbuDQ5JhNdqcg7QnQrwQbBcLaqkhwba78ANx5mMr5XRMF8i/XXUCsq0j0FqIQZKQe28aM7fLh1xhJW3ZMOg/UqDWk/+mDrf4r+ExbkCqSCn77ACJF4lVkW1da3XkIMRd7p489g4odIadjAi4R81mxx0CgYEA/NA8jpi3dc+vWqelACM/VUj14sCQx4CahGebAtBLp3M6/dJeHi8JoyEeZsPIhsj617IvD6+kywJm4MzT5XKUF92kdyD3n8xnqxR9z3TFEpMFyn8T+g+YCoMoC/InskFnf0smhBjgGiJCZB0gaMza0cY/EBRr2wXdlktCUkdFQscCgYEA6h+eO0T7g4U/cFmaej9rVMdcpRvawcedu0+kzXmp5v3nfeZK4U59cc1LeIkXehO9QaZJzmWxDhCeqhuXjp+JsFWnB4w99asO70+P6jxSWPkV2O9oTONzvOcVC+TV7fmLomP6qAfRXgvUM7F/PcJys+zwEp6Ae8CKj3Lok161BmMCgYEA7jlextPbFFWWnCsazQ1psXil0ny4MHXbpGZoZ/dVQr3PWbwwWeri/ufHWPil7XRXAodx1ysgcveZb70y8qPMLsz5HBRhoh+flFMj1ifnSABoVY73iQvGrik2xELz6wG8f/OVoKY8DgQ4YVQc5QQcMc3IQOOtWl6llejm3tcvyaMCgYA57DSjiT+InHDDhQeY8xPE18Xt+2Q1yQMXEm89frowMeUR2uXvtBGJFDd1zMUIKNYL5e4gqDwTtLzsbQMkAAh6ndZDIck6fGWng1Ghq+bbqFRlZWWykBtUQv+L/8OFqtWHCaE77SM5V0faujE2wGLMbPRARwKWm14se0tbGnVC7QKBgF7ZwmZTDwX4GROrqIo7+5420yj54PrDtLTBdXq3lU0uMLNV0JHG4lWfMIsXZh6gzWl27YTa0I8DuFnwAYa3nnmpMT4PhrFtp2LuYDjDdKNVr8OJa0uGyvcvB5Gpq+Yw9YjEOvp5gsX8ARmM77vfI01+KiDDT9r95+BWnYa9z144",

        //沙箱环境
        'merchant_private_key' => "MIIEpQIBAAKCAQEA8vcl4Medr0mbHoGhOxZYc1OLLu5QhTTZpnxSIql9LZSIKB6/PpmNbibPSHE/UoNpN+M2DAOnGfCM7l2iT8zBxvRPulB/R9zvyY6iqCASQgU5cG+XtfsNDWOR5ftYMagbrhxGpwf3APoV6ou1sPytmhNLdcLkyh1MXn+8GaWfpnsJSu7fUpMWG0jHlv/ctGSYWloP3G3oWvsGcl/0DO6nfWbVqZEHf987I0k+cwi4BstsLB5N1TXWAS2Cfa617P7vW690JL2Lb56bnVF+GOpu6fatBa2MmnwWbcDoclWgxfEwbaqQWgbCLqwOU9XSee3no07PgwCjgLmpDTvzwU47iwIDAQABAoIBAQCjavhfJ+Q3chqTej0nsO/tIdQLzN77uYBrKlNUXQuFDNJHqeaYBE/MNu5Um1cr+Jdcr8Y6bnqGR/WCnhf99IqhdtHpTxtNCp19xCJDUs70+O6ZYXV5QVKWHtKTDWtUeu2jPgGHdyP71DnJeA7M7CcX6sJmgp/AEdS7+s5ZsbygC/HABliaTpMUTgOe+4+9wh5aHb48Fbyl5ETtefJypgi+aW727HXgLvHGlOcx+TdZy1mscwU+KhIhbJZ3EJcnfraV1z8vD1UkhkMOiW7b3xUmDVeDlovSWxbQEdPu4KIiJEas+9u101EPxtwY60q9IpW1C0f7c56AwjXO5sNCsZ+BAoGBAPxSFJN/Vn0Kjn+jKEi0Q2SDYiD83PY/rGt2cTlTNcuYxP6tcRgQABKg++BFLjpn7qClZsBBNp3IhIrc+VWEar5wBgQ2D1IZ8M/Ixxo3mg03PgCSt7t8eElR/0SgAESuNruru/8UN7ylTxYQ4tDL2iLCHCmmDUTP8A8YRNbdB9JHAoGBAPaCJPSRUDg5VAVYS6UjDrvOcT2dMmS0b+bMXO9ul4bX+26J23hsZ9XGvzXPoNMvJ5O6TtH2OC3XGXMxWNYvxPx8cmXz/FjQFXP9ubPa6hGR0ALccBsIC42rvDoqTdPCkxlQpTOY+r90mHa6xpGRMaxlmxwFTek2OCPwhmLOmIqdAoGAEpl+WM0XNAp2LKR7ULixCxTARAw/wYs6C4XknMQsgACX7OoeHxb22mixiHuxB68noQHwTBXCj+j7FD1rx8kGEVmyp9bQVE4DOV3kh2M34OeEk4g9MP3g5A6+UXG181ogQL9NEWWNIkPRS6AdCCUuxEcoyk0qRztIx+QTFv+eFvsCgYEA1tZ0GMYwkN+9z261drXIGHwCi31eNxBe2lpPwMi0vOutkRgKs7hfApxVdzN+aa+WIZTlLu4U5jaqUo+2ae12E8rt9NcgndK0b8O4vfxTtX5MOMIf3h8z2oPK5zKJY74Xb5+uavqvxn56hjef6awOC7794Pzqew8q/H+az7BYl60CgYEAnaePjNbNq0QQtWxdNgBg868KcL64OdfDE12RDqa0US2+Yd/7LZMN1xu19Le8LsWJCOwBfnvRPGcTypkrZF7ZQ5bn8CUseW741d4GfDiJp/JSFM2J4Gb8/n/o/5L/aBtOHKBITcuR/pmMrMkihROrW3prCEocrZ1RdyjgJAM6Gx0=",

        //异步通知地址
        'notify_url' => "http://www.cs0663.cn/notify.php",

        //同步跳转
        'return_url' => "http://www.cs0663.cn/pay.php?act=return&type=ant",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        //'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

        //沙箱环境
        'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        //'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1Bvq1CjlICx/tdZYHE98qFApl5XIdEaDB9lC+gKUnvQbe+9pQ0hqCqZKzfK3LORyM8Fck38xiImM/UtbqM9Ya3K5upqCs0Vzt3W7KDLTDRfLfDI4KTP9gf2FCT31YdQq61TL7m7nFamqq/k6UIH5yGcHrDcrLOLRnHRdidl+sOfCK+1kRtg/jiBqmOVhdXl4gnLZ1t6xjtsDAlcfPy2FKDbJ7eIHprganlfcvwjdIOBxDiFkwTGf4uVoUsOZwdjZilXhtqEcLQUFTe4IwAuZK0wuF990hBjsQxm57t3DWUxNY4mQEkHJDb2m/MbKIW2i464tCCNSQf6iSrtKBsH9nQIDAQAB",

        //沙箱环境
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyN9PxyOi/PUx3QrFUMyTTnZ/0d+5YN72T47JrH5UPeZ/U64XUZ3zKhjjZeKJRR9a8ooDGiXCSNfJhwEvPPPlCu2s2SEQR9WExQTVVdevGLKBhd+WlRznUIAUJrZ1a4WZShNf3z80dLgAH/OkDt5rzCOC4mfNBg/HaNr0jgvaszYnI5LJWdVugsIjM9xplUBItVfKMARh0FV0Ppb3SFoAA5bSl7dFR0ZzLo4qFUS9uXSULsIsiSht4tlbecjwb4SgebdAgAB0L8QKX40rQy9MvGPS1x8YGhUsh+shJlzwNFfCg2xN0YnwDInFEX6HEEGFoCJO7fvtHe1ELAFLIyJB6QIDAQAB",
    );
}
