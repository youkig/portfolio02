<!--#include file="../config.inc"-->
<%
Response.ContentType = "text/html"
Response.Charset= "shift_jis"
nmonth = clng2(request.querystring("month"))
str=""
            today=dateadd("m",nmonth,date)
            nowday =date
	        tmonth=year(today)&"/"&month(today)
            
            nextmonth=dateadd("m",1,today)
			lastday=day(dateadd("d",-1,dateserial(year(nextmonth),month(nextmonth),1)))
			firstweek=weekday(dateserial(year(today),month(today),1))
        %>
        
       <!--#include file="../include/calender.inc"-->   
        <%

			   loop1=(lastday+firstweek-1) / 7
			   amari=(lastday+firstweek-1) mod 7
			   if amari>0 then
			   loop1=loop1+1
			   end if
			   
            str="<p>"&replace(tmonth,"/","”N")&"Œ</p>" 
            str=str & "<table summary=""—\–ñƒJƒŒƒ“ƒ_["" class=""atten"">" &vbcrlf
            str=str & "<thead>" &vbcrlf
            str=str & "<tr>" &vbcrlf
            str=str & "<th abbr=""“ú"" class=""first"">“ú</th>" &vbcrlf
            str=str & "<th abbr=""Œ"">Œ</th>" &vbcrlf
            str=str & "<th abbr=""‰Î"">‰Î</th>" &vbcrlf
            str=str & "<th abbr=""…"">…</th>" &vbcrlf
            str=str & "<th abbr=""–Ø"">–Ø</th>" &vbcrlf
            str=str & "<th abbr=""‹à"">‹à</th>" &vbcrlf
            str=str & "<th abbr=""“y"" class=""last"">“y</th>" &vbcrlf
            str=str & "</tr>" &vbcrlf
            str=str & "</thead>" &vbcrlf
                      
            str=str & "<tbody>" &vbcrlf
             
				   c=lastday+firstweek
				   cnt=0
				   for a=1 to loop1
				   
			
             str=str & "<tr style=""border:1px solid;"">" &vbcrlf
                   
				   cnt1=0
				   for b=1 to c
				   echk=0
				   cnt1=cnt1+1
				   if cnt1<=7 then
				   classname=""
				   if cnt1=1 then classname=" class='first'"
				   if cnt1=7 then classname=" class='last'"
				   if dateserial(year(tmonth),month(tmonth),cnt)<nowday then
                   classname = " class='endday'"
                   end if
              str=str & "<td" & classname & ">" &vbcrlf
                 
							if b>=firstweek OR cnt>0 then
							cnt=cnt+1
                                if cnt<=lastday then
               str=str & cnt
               dchk=0
               if isArray(darray) then
                   if ubound(darray)>0 then
                        for d=0 to ubound(darray)
                            if darray(d)<>"" then
                               if dateserial(year(tmonth),month(tmonth),cnt)=datevalue(darray(d)) then
                                   if instr(sarray(d),"‹x“ú ")>0 then
                                   str=str & "<span class='red'>" & " U‘Ö‹x“ú" & "</span>"
                                   else
                                   str=str & "<span class='red'>" & sarray(d) & "</span>"
                                   end if
                                   dchk=1
                               end if
                           end if
                       next
                   end if
               end if
               week = weekday(dateserial(year(tmonth),month(tmonth),cnt))
               'j“ú‚ğ’è‹x“ú‚É‚µ‚È‚¢ê‡‚Íuor dchk=1v‚ğ’Ç‰Á
               rkyu = 0
               if instr("," & r & ",",","&cnt&",")>0 and week<>2 and week<>6 then
                rkyu = 1
                str=str & "<span class=""red""> —Õ‹x“ú</span>"
               end if
               SQL="SELECT * from t_—Õ‰c‹Æ Where edate='" & dateserial(year(tmonth),month(tmonth),cnt) & "' and cancel=0"
                set rse=db.execute(SQL)
                if not rse.eof then
                echk=1
                end if
                if dateserial(year(tmonth),month(tmonth),cnt)>nowday and week<>2 and week<>6 and rkyu=0 then
               str=str & "<br>"
               str=str & "<p class=""centering"">"
               
                   if yn(cnt)<10 then
                   str=str & "<button type=""button"" class=""yoyakubtn"" id=""yoyaku_" & year(tmonth) & "_" & month(tmonth)& "_" & cnt &""">—\–ñ</button><br>" &vbcrlf
                   str=str & "c‚èF<br class=""br-sp2"">" & 10-yn(cnt) & "‘g</p>" &vbcrlf
                   else
                   str=str & "—\–ñI—¹" &vbcrlf
                   end if
               
                end if
                if (week=2 or week=6) and echk=0 then
                str=str & "<p class=""red centering small"">’è‹x“ú</p>"
                
            elseif (week=2 or week=6) and echk=1 then
           
                  str=str & "<br>"
               str=str & "<p class=""centering"">"
               
                   if yn(cnt)<10 then
                   str=str & "<button type=""button"" class=""yoyakubtn"" id=""yoyaku_" & year(tmonth) & "_" & month(tmonth)& "_" & cnt &""">—\–ñ</button><br>" &vbcrlf
                   str=str & "c‚èF<br class=""br-sp2"">" & 10-yn(cnt) & "‘g</p>" &vbcrlf
                   else
                   str=str & "—\–ñI—¹" &vbcrlf
                   end if
   
                end if
                                end if
					   		end if
				       
                            
               str=str & "</td>" &vbcrlf
                           
               
				   if cnt1=7 then exit for
				   end if
				   next
				         
               str=str & "</tr>" &vbcrlf
               
				next
				 
           
                str=str & "</tbody>"&vbcrlf
             str=str & "</table>"&vbcrlf
            response.write(str)
%>
             