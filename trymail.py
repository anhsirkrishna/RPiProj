#!/usr/bin/python3

import smtplib
from email.mime.text import MIMEText

addr_to = 'ss3krish@gmail.com'
addr_from = 'krasbpi@gmail.com'

smtp_server = 'mail.google.com'
smtp_user = 'krasbpi@gmail.com'
smtp_pass = 'jxywhamgvbayahkx'

msg = MIMEText('This is a test email')
msg['To'] = addr_to
msg['From'] = addr_from
msg['Subject'] = 'Test Email'
try:
	s = smtplib.SMTP(smtp_server,587)
	s.ehlo()
	s.starttls()
	s.login(smtp_user,smtp_pass)
	s.sendmail(addr_from,addr_to, msg.as_string())
	s.quit()
except smtplib.SMTPException:
	print(str(smtplib.SMTPException))

