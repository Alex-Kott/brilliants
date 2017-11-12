# encoding=utf8
from bs4 import BeautifulSoup
from tqdm import tqdm
import MySQLdb
import requests as req
import zipfile 
import os

from config import *

db = MySQLdb.connect(host=db_host, 
					user=db_user,
					passwd=db_password, 
					db=db_name, 
					charset="utf8")
cursor = db.cursor()





update_url = "http://idexonline.com/Idex_Feed_API-Inventory_Update?String_Access=359H1HDXPHHVWW27387ZOOEQD"

response = req.get(update_url, stream=True)
with open(data_folder.format('update.zip'), 'wb') as f:
	for data in tqdm(response.iter_content()):
		f.write(data)

zs = zipfile.ZipFile(data_folder.format('update.zip'))
zs.extractall('data/')
extract_file = zs.namelist()[0]


with open(data_folder.format('update.zip'), "rb") as f:
	data = f.read()
	f.close()


soup = BeautifulSoup(data, "lxml")
items = soup.find_all("item")
for i in items:
	attrs = i.attrs
	item = {
		'id'	: attrs.get('id'),
		'cut'	: attrs.get('cut' ''),
		'ct'	: attrs.get('ct', 0.0),
		'col'	: attrs.get('col', ''),
		'cl'	: attrs.get('cl', ''),
		'mk'	: attrs.get('mk', ''),
		'lab'	: attrs.get('lab', ''),
		'cn'	: attrs.get('cn', ''),
		'cp'	: attrs.get('cp', ''),
		'ap'	: attrs.get('ap', 0),
		'tp'	: attrs.get('tp', 0.0),
		'pol'	: attrs.get('pol', ''),
		'sym'	: attrs.get('sym', ''),
		'mes'	: attrs.get('mes', ''),
		'dp'	: attrs.get('dp', 0.0),
		'fl'	: attrs.get('fl', ''),
		'cty'	: attrs.get('cty', ''),
		'st'	: attrs.get('st', ''),
		'idxl'	: attrs.get('idxl', 0)
	}
	print(item, end='')

	try:
		sql = '''INSERT INTO stones(id, cut, ct, col, cl, mk, lab, cn, cp, ap, tp, pol, sym, mes, dp, fl, cty, st, idxl) 
			VALUES ({}, '{}', {}, '{}', '{}', '{}', '{}', '{}', '{}', {}, {}, '{}', '{}', '{}', {}, '{}', '{}', '{}', {})'''.format(item['id'], item['cut'], item['ct'], item['col'], item['cl'], item['mk'], item['lab'], item['cn'], item['cp'], item['ap'], item['tp'], item['pol'], item['sym'], item['mes'], item['dp'], item['fl'], item['cty'], item['st'], item['idxl'])
		cursor.execute(sql)
		db.commit()
	except Exception as e:
		print(e)
		pass

db.close()

os.remove(data_folder.format(extract_file))
os.remove(data_folder.format('update.zip'))