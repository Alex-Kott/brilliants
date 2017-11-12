# encoding=utf8  
from bs4 import BeautifulSoup
import MySQLdb
from psycopg2.extras import execute_values
import psycopg2.extras
from tqdm import tqdm
import requests as req
import zipfile

from config import *

db = MySQLdb.connect(host=db_host, 
					user=db_user,
                    passwd=db_password, 
                    db=db_name, 
                    charset="utf8")
cursor = db.cursor()

def download_data():
	full_data_url = "http://idexonline.com/Idex_Feed_API-Full_Inventory?String_Access=359H1HDXPHHVWW27387ZOOEQD"

	response = req.get(full_data_url, stream=True)
	with open(data_folder.format('data.zip'), 'wb') as f:
		for data in tqdm(response.iter_content()):
			f.write(data)


def get_filename():
	zs = zipfile.ZipFile(data_folder.format('data.zip'))
	zs.extractall('data/')
	extract_file = zs.namelist()[0]
	return extract_file

download_data()
extract_file = get_filename()


with open(data_folder.format(extract_file), "rb") as f:
	data = f.read()
	f.close()



soup = BeautifulSoup(data, "lxml")
items = soup.find_all("item")
for i in items:
	print(i)
	continue
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

# print(i)
db.close()