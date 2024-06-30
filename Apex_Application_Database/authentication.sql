FUNCTION GETMD5(pstring IN VARCHAR2) RETURN VARCHAR2 IS
        hasil VARCHAR2(32) := '';
BEGIN
        hasil := DBMS_OBFUSCATION_TOOLKIT.MD5(input => UTL_I18N.STRING_TO_RAW (pstring, 'AL32UTF8'));
        RETURN hasil;
END GETMD5;




FUNCTION user_auth    (
    
 p_username IN VARCHAR2, --User_Name
 p_password IN VARCHAR2 -- Password    
)
 RETURN BOOLEAN
AS
 lc_pwd_exit VARCHAR2 (1);
 HASHPASS VARCHAR2(32) := GETMD5(p_password);
BEGIN
 -- Validate whether the user exits or not
 SELECT '1'
 INTO lc_pwd_exit
 FROM hhf_user
 WHERE upper(USERNAME) = UPPER (p_username) and upper(USER_PASSWORD) = UPPER (HASHPASS) and (upper(USER_ROLE) = 'T'  OR upper(USER_ROLE) = 'A')
;
RETURN TRUE;
EXCEPTION
 WHEN NO_DATA_FOUND
 THEN
 RETURN FALSE;
END user_auth;