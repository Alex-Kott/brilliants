import requests as req
import MySQLdb
import MySQLdb.cursors
from bs4 import BeautifulSoup

def download_file(id, url):
	local_filename = "certificates/{}.pdf".format(id)
	# NOTE the stream=True parameter
	r = req.get(url, stream=True)
	with open(local_filename, 'wb') as f:
	    for chunk in r.iter_content(chunk_size=1024): 
	        if chunk: # filter out keep-alive new chunks
	            f.write(chunk)
	            #f.flush() commented by recommendation from J.F.Sebastian
	return local_filename


db = MySQLdb.connect(host="localhost", user="root", passwd = "toor", db="brilliants", charset="utf8", cursorclass=MySQLdb.cursors.DictCursor)
cursor = db.cursor()

sql = '''select * from stones 
		where `cut` = 'Round' and
		`cl` IN ('IF', 'FL') and
		(`ct` BETWEEN 0.001 AND 2.08) and
		`lab` = 'GIA' AND
		`sym` IN ('Ideal', 'Excellent') AND
		`pol` IN ('Ideal', 'Excellent') AND
		`mk` IN ('Ideal', 'Excellent')
'''


cursor.execute(sql)
data = cursor.fetchall()
for i, item in enumerate(data):
	# download_file(item['id'], item['cp'])
	res = req.post(item['cp'])
	# print(res.text)

	soup = BeautifulSoup(res.text, "lxml")
	try:
		# print(soup.iframe['src'])
		download_file(item['id'], "http://diamondtransactions.net{}".format(soup.iframe['src']))
	except:
		pass


db.close()