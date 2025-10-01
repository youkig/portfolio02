<!--#include File ="../config.inc"-->
<%
dim newid,faqid,b1id,b2id,makerid,oid1,oid2,goodsid,memid
newid = cint2(request("newid"))
faqid = cint2(request("faqid"))
b1id = cint2(request("b1id"))
b2id = cint2(request("b2id"))
makerid = cint2(request("makerid"))
oid1 = cint2(request("oid1"))
oid2 = cint2(request("oid2"))
goodsid = cint2(request("goodsid"))
memid = cint2(request("memid"))
sid = cint2(request("sid"))

if newid <> 0 then
	sql="select * from t_‚¨’m‚ç‚¹ where id = " & newid
	set rs=db.execute(sql)
	if not rs.eof then
		SQL = "DELETE FROM t_‚¨’m‚ç‚¹ WHERE ID = " & newid
		db.execute(SQL)
		response.write "success"
	end if
	rs.close
end if

if faqid <> 0 then
	sql="select * from t_faq where id = " & faqid
	set rs=db.execute(sql)
	if not rs.eof then
		SQL = "DELETE FROM t_faq WHERE ID = " & faqid
		db.execute(SQL)
		response.write "success"
	end if
	rs.close
end if

if b1id <> 0 then
	sql="select * from t_bunrui1 where id = " & b1id
	set rs=db.execute(sql)
	if not rs.eof then
		if rs("bunrui1img1")<>"noimage" then
			strpath= Server.MapPath("../../photo/category")
			strpath = strpath & "\"&rs("bunrui1img1")
			if fs.fileExists(strpath) then
				fs.deletefile strpath
			end if
		end if
		SQL = "DELETE FROM t_bunrui1 WHERE ID = " & b1id
		db.execute(SQL)
		response.write "success"
	end if
	rs.close
end if

if b2id <> 0 then
	sql="select * from t_bunrui2 where id = " & b2id
	set rs=db.execute(sql)
	if not rs.eof then
		if rs("bunrui2img1")<>"noimage" then
			strpath= Server.MapPath("../../photo/category")
			strpath = strpath & "\"&rs("bunrui2img1")
			if fs.fileExists(strpath) then
				fs.deletefile strpath
			end if
		end if
		SQL = "DELETE FROM t_bunrui2 WHERE ID = " & b2id
		db.execute(SQL)
		response.write "success"
	end if
	rs.close
end if

if sid <> 0 then
	sql="select * from t_master where id = " & sid
	set rs=db.execute(sql)
	if not rs.eof then
	
	
			imgnames = rs("image1")
		
				
			strpath= Server.MapPath("../photo/goods")
			strpath = strpath & "\"&imgnames
		'response.write(strpath)
		Set fs = CreateObject("Scripting.FileSystemObject")
			if fs.fileExists(strpath) then
				fs.deletefile strpath
			end if
			
		SQL = "DELETE FROM t_master WHERE id = " & sid
		db.execute(SQL)

		str="success"
		response.write "success"
		
		
	end if
	rs.close
end if

if oid1 <> 0 then
	sql="select * from t_optionset1 where id = " & oid1
	set rs=db.execute(sql)
	if not rs.eof then
		SQL = "DELETE FROM t_optionset1 WHERE id = " & oid1
		db.execute(SQL)
		response.write "success"
	end if
	rs.close
end if

if oid2 <> 0 then
	sql="select * from t_optionset2 where id = " & oid2
	set rs=db.execute(sql)
	if not rs.eof then
		SQL = "DELETE FROM t_optionset2 WHERE id = " & oid2
		db.execute(SQL)
		response.write "success"
	end if
	rs.close
end if

if goodsid <> 0 then
	sql="select * from t_master where id = " & goodsid
	set rs=db.execute(sql)
	if not rs.eof then
		'for i = 1 to 4
		'	if rs("imgname"&i) <>"" then
		'		if fs.FileExists(server.MapPath("../../photo/goods") & "\" & rs("imgname"&i)) Then
		'			set objfile = fs.getfile(server.MapPath("../../photo/goods") & "\" & rs("imgname"&i))
		'			objfile.Delete true
		'		end if
		'	end if
		'next
		
		SQL = "UPDATE t_master set disp3=0 WHERE id = " & goodsid
		db.execute(SQL)
		response.write "success"
	end if
	rs.close
end if

if memid <> 0 then
	sql="select * from t_user where id = " & memid
	set rs=db.execute(sql)
	if not rs.eof then
		SQL = "DELETE FROM t_user WHERE id = " & memid
		db.execute(SQL)
		response.write "success"
	end if
	rs.close
end if

%>
