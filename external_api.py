url = 'http://0.0.0:8069'
db = 'demo'
user = 'demo'
password = 'demo'
import xmlrpc.client
common = xmlrpc.client.ServerProxy('{}/xmlrpc/2/common'.format(url))
uid = common.authenticate(db, user, password, {})

models = xmlrpc.client.ServerProxy('{}/xmlrpc/2/object'.format(url))
res_partner  = models.execute_kw(db, uid, password, 'res.partner', 'search', [[['is_company', '=', True]]])
print( res_partner )
print( "version info ", common.version() )