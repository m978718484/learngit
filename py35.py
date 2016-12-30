#!/usr/bin/env python
#coding: utf-8

import time
import csv

from selenium import webdriver
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.phantomjs.service import Service as IEDriverServer

def	get_element_by_class_name(className):
	try:
		text = driver.find_element_by_class_name(className).text
		return text
	except:
		return ''

header = ['ID','標題','作者','摘要','出版源','關鍵詞','被引量']
with open("out.csv","w", newline='') as datacsv:
    csvwriter = csv.writer(datacsv,dialect=("excel"))
    csvwriter.writerow(header)

lines = []
with open('test.txt','r') as f:
	lines = f.readlines()

driver = driver=webdriver.Ie(executable_path=r'.\browser-driver\IEDriverServer')
for key in lines:
	id_key = key.split('\t')	
	driver.get("http://xueshu.baidu.com/")
	time.sleep(3)

	driver.find_element_by_id("kw").send_keys(id_key[1])
	driver.find_element_by_id("su").click()
	author_text = get_element_by_class_name("author_text")
	if author_text  == '':
		time.sleep(5) #如果点查询没有直接跳到详情页，等待人为点选页面，这个时间你自己把控吧

	all_handles = driver.window_handles #获取窗口数
	author_text = None
	abstract = None
	kw_main = None
	sc_cite_cont = None
	if len(all_handles)>1:
		driver.switch_to_window(all_handles[1])#如果窗口数大于1,切换到新窗口
	try:
		span_more = driver.find_element_by_css_selector("i.c-icon.c-icon-triangle-down-d");
		span_more.click()
		time.sleep(3)
	except Exception as e:
		pass
	title = driver.find_element_by_tag_name("h3").text
	author_text = get_element_by_class_name("author_text")
	abstract = get_element_by_class_name("abstract")
	publish_text = get_element_by_class_name("publish_text")
	kw_main = get_element_by_class_name("kw_main")
	try:
		sc_cite_cont =  driver.find_element_by_class_name("sc_cite_cont").text
		print(sc_cite_cont)
	except:
		sc_cite_cont = 0	
	data = [id_key[0],title,author_text,abstract,publish_text,kw_main,sc_cite_cont]
	if len(all_handles)>1:
		driver.close()
		driver.switch_to_window(all_handles[0])
	with open("out.csv","a", newline='') as datacsv:
	    csvwriter = csv.writer(datacsv,dialect=("excel"))
	    csvwriter.writerow(data)
driver.quit()