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
 * 核心请求处理类 
 * @author 
 * @Email 
 * 
 */
public class WeixinServlet extends HttpServlet {

    private static final long serialVersionUID = -5021188348833856475L;
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)throws ServletException, IOException {
        // 微信加密签名  
        String signature = request.getParameter("signature");  
        // 时间戳  
        String timestamp = request.getParameter("timestamp");  
        // 随机数  
        String nonce = request.getParameter("nonce");  
        // 随机字符串  
        String echostr = request.getParameter("echostr");  

        PrintWriter out = response.getWriter();  
        // 通过检验signature对请求进行校验，若校验成功则原样返回echostr，表示接入成功，否则接入失败  
        if (SignUtil.checkSignature(signature, timestamp, nonce)) {  
            out.print(echostr);  
        }  
        out.close();
        out = null;
    }
  
    //信息处理  
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
            request.setCharacterEncoding("UTF-8");  
            response.setCharacterEncoding("UTF-8");  
         // 微信加密签名  
            String signature = request.getParameter("signature");  
            // 时间戳  
            String timestamp = request.getParameter("timestamp");  
            // 随机数  
            String nonce = request.getParameter("nonce");  
            // 通过检验signature对请求进行校验，若校验成功则原样返回echostr，表示接入成功，否则接入失败  
          if (SignUtil.checkSignature(signature, timestamp, nonce)) { 
               // 调用核心业务类接收消息、处理消息
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
    

