select 1
from   HHF_USER
where  UPPER(USERNAME) = UPPER(:APP_USER)
and    USER_ROLE = 'A'

select 1
from   HHF_USER
where  UPPER(USERNAME) = UPPER(:APP_USER)
and    USER_ROLE = 'T'