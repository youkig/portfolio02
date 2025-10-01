<!--#include File ="../../inc/config.inc"-->
<%
Response.ContentType = "text/html"
Response.Charset= "shift_jis"

dim userid,str
userid = cint2(request("id"))
str = ""
if userid <> 0 then
	sql = "select * from t_user where id = " & id
	set rs = db.execute(sql)
	str = "{"
	do until rs.eof
		str = str & """name"":"""& rs("name") &""",""furigana"":"""& rs("furigana") &""",""company"":"""& rs("company") &""",""busyo"":"""& rs("busyo") &""",""phone"":"""& rs("phone") &""",""zip"":"""& rs("zip") &""",""state"":"""& rs("state") &""",""address"":"""& rs("address") &""""
	rs.movenext
	loop
	rs.close
	str = str & "}"
end if
response.write str
%>
