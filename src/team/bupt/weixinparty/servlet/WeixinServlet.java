package team.bupt.weixinparty.servlet;
import java.io.IOException;
import java.io.InputStream;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import team.bupt.weixinparty.process.ProcessRequest;
//import com.javen.course.service.CrazyService;
import team.bupt.weixinparty.util.SignUtil;

/**
 * ������������ 
 * @author 
 * @Email 
 * 
 */
public class WeixinServlet extends HttpServlet {

    private static final long serialVersionUID = -5021188348833856475L;
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)throws ServletException, IOException {
        // ΢�ż���ǩ��  
        String signature = request.getParameter("signature");  
        // ʱ���  
        String timestamp = request.getParameter("timestamp");  
        // �����  
        String nonce = request.getParameter("nonce");  
        // ����ַ���  
        String echostr = request.getParameter("echostr");  

        PrintWriter out = response.getWriter();  
        // ͨ������signature���������У�飬��У��ɹ���ԭ������echostr����ʾ����ɹ����������ʧ��  
        if (SignUtil.checkSignature(signature, timestamp, nonce)) {  
            out.print(echostr);  
        }  
        out.close();
        out = null;
    }
  
    //��Ϣ����  
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
            request.setCharacterEncoding("UTF-8");  
            response.setCharacterEncoding("UTF-8");  
         // ΢�ż���ǩ��  
            String signature = request.getParameter("signature");  
            // ʱ���  
            String timestamp = request.getParameter("timestamp");  
            // �����  
            String nonce = request.getParameter("nonce");  
            // ͨ������signature���������У�飬��У��ɹ���ԭ������echostr����ʾ����ɹ����������ʧ��  
          if (SignUtil.checkSignature(signature, timestamp, nonce)) { 
               // ���ú���ҵ���������Ϣ��������Ϣ
               String respMessage = null;
             try {
            	 respMessage = ProcessRequest.process(request,response);
               } catch (Exception e) {
                   e.printStackTrace();
              }
               PrintWriter out = response.getWriter();
               out.print(respMessage);
               out.close();
           } 
            
     }
}
    

