#!/usr/bin/python
import os,MySQLdb,time

while True:
	##########################################################################
	##########################################################################
	db	= MySQLdb.connect("127.0.0.1","root","ENTER MYSQL PASSWORD","ENTER DATABASE NAME" )
	try:
		os.system("rm /var/www/html/fullhood.com/sitemap.xml")
		os.system("rm /var/www/html/fullhood.com/sitemap2.xml")
	except:
		pass
	cursor	= db.cursor()
	sql = "SELECT * FROM news ORDER BY id DESC"
	counter=0
	data='<?xml version="1.0" encoding="UTF-8"?> \r\n \
	  <urlset \r\n	\
	  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" \r\n	\
	  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" \r\n \
	  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 \r\n	\
	  http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"> \r\n <url>	\r\n \
	  <loc>https://www.fullhood.com/</loc><priority>1.0</priority> \r\n <changefreq>always</changefreq> \r\n	</url> \
	  <url><loc>https://www.fullhood.com/index.php</loc><priority>0.9</priority> \r\n	<changefreq>hourly</changefreq>	\r\n </url>	\r\n \
	  <url><loc>https://www.fullhood.com/index.php?lang=en</loc><priority>1.0</priority> \r\n	<changefreq>hourly</changefreq>	\r\n </url>	\r\n \
	  <url><loc>https://www.fullhood.com/index.php?lang=gr</loc><priority>0.9</priority> \r\n	<changefreq>hourly</changefreq>	\r\n </url>	\r\n \
	  <url><loc>https://www.fullhood.com/index.php?title=fullhood</loc><priority>0.9</priority> \r\n <changefreq>hourly</changefreq> \r\n </url> \r\n '
	data2='<?xml version="1.0" encoding="UTF-8"?> \r\n \
	  <urlset \r\n	\
	  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" \r\n	\
	  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" \r\n \
	  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 \r\n	\
	  http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"> \r\n <url>	\r\n \
	  <loc>https://fullhood.com/</loc><priority>1.0</priority> \r\n <changefreq>always</changefreq> \r\n	</url> \
	  <url><loc>https://fullhood.com/index.php</loc><priority>0.9</priority> \r\n	<changefreq>hourly</changefreq>	\r\n </url>	\r\n \
	  <url><loc>https://fullhood.com/index.php?lang=en</loc><priority>1.0</priority> \r\n	<changefreq>hourly</changefreq>	\r\n </url>	\r\n \
	  <url><loc>https://fullhood.com/index.php?lang=gr</loc><priority>0.9</priority> \r\n	<changefreq>hourly</changefreq>	\r\n </url>	\r\n \
	  <url><loc>https://fullhood.com/index.php?title=fullhood</loc><priority>0.9</priority> \r\n <changefreq>hourly</changefreq> \r\n </url> \r\n '


	'''try:
		cursor.execute(sql)
		results =	cursor.fetchall()
		for row in results:
			title = row[1]
			id =	row[0]
			lang	= row[4]
			counter+=1
			title=title.replace(" ","_").replace("/","_").replace("\\","_").replace("'","_").replace('"',"_").replace('.',"_").replace(',',"_")
			title=title.replace('&',"").replace('?',"").replace('"',"").replace("'","")
			datalink="https://www.fullhood.com/news.php?nid="+str(id)+"&amp;lang="+str(lang)+"&amp;title="+str(title)
			datalink2="https://fullhood.com/news.php?nid="+str(id)+"&amp;lang="+str(lang)+"&amp;title="+str(title)

			print (datalink)
			data += "<url> \r\n	<loc>"+datalink+"</loc><priority>0.9</priority> \r\n	<changefreq>hourly</changefreq>	\r\n </url>	\r\n  "
			data2 += "<url> \r\n	<loc>"+datalink2+"</loc><priority>0.9</priority> \r\n	<changefreq>hourly</changefreq>	\r\n </url>	\r\n  "
	except:
		print	("Error:	unable to fecth	data")'''
	print()
	data+="</urlset>"
	data2+="</urlset>"
	print (str(counter)+" results")
	a=	open("/var/www/html/fullhood.com/sitemap.xml","a")
	a.write(data)
	a.close()
	a=	open("/var/www/html/fullhood.com/sitemap2.xml","a")
	a.write(data2)
	a.close()
	db.close()
	time.sleep(600)
