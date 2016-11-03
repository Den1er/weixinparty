package team.bupt.weixinparty.process;

import java.util.Date;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import team.bupt.weixinparty.util.MessageUtil;
import team.bupt.weixinparty.process.XmlToMap;
import team.bupt.weixinparty.resp.TextMessage;

public class ProcessRequest {
	     public static String process(HttpServletRequest request,HttpServletResponse response) throws Exception{
	 	         @SuppressWarnings("unchecked")
	        
	         Map<String, String> map = XmlToMap.parseXml(request);
	   // 	         System.out.println(map);
	         String result = "";
	         String msgType = map.get("MsgType");
	         String respContent = "";
	       //文本消息
	       
	          
            // 测试
	 	/*        String result = "";
	         TextMessage textMessage = new TextMessage();
	            textMessage.setToUserName("!CDATA["+"aaaaaaaaa"+"]");// 发送和接收信息“User”刚好相反
	            textMessage.setFromUserName("!CDATA["+"bbbbbbbbb"+"]");
	            textMessage.setCreateTime(new Date().getTime());// 消息创建时间 （整型）
	            textMessage.setMsgType("!CDATA["+"text"+"]");// 文本类型消息
	            textMessage.setContent("!CDATA["+"Congratulation!!!"+"]");
	            result = MessageUtil.textMessageToXml(textMessage);
	            Map<String, String> map =XmlToMap.parseXml(request);
	            System.out.println("oooooooooooo");
	            System.out.println(map);
	            System.out.println("oooooooooooo");*/
	       if (msgType.equals("text")) {
	            TextMessage textMessage = new TextMessage();
	            textMessage.setToUserName(map.get("FromUserName"));// 发送和接收信息“User”刚好相反
	            textMessage.setFromUserName(map.get("ToUserName"));
	            textMessage.setCreateTime(new Date().getTime());// 消息创建时间 （整型）
	            textMessage.setMsgType("!CDATA["+"text"+"]");// 文本类型消息
	            textMessage.setContent("!CDATA["+"Congratulation!!!"+"]");
	            
	            // // // 第二步，将构造的信息转化为微信识别的xml格式【百度：xstream bean转xm      
	              result = MessageUtil.textMessageToXml(textMessage);
	           

	        }
	        //图片消息
	      else if (msgType.equals("image")) {
	            respContent = "";
	            return null;
	        }
	        //声音消息
	        else if (msgType.equals("voice")) {
	            respContent = "";
	            return null;
	        }
	        //视频消息
	        else if (msgType.equals("video")) {
	            respContent = "";
	            return null;
	        }
	        //地理位置
	        else if (msgType.equals("location")) {
	            respContent = "";
	            return null;
	        }
	        //事件类型
	        else if (msgType.equals("event")) {
	            String eventType = map.get("Event");
	            //订阅
	           if (eventType.equals("subscribe")) {
	  //             respContent = "欢迎订阅我的公众号！";
	//               TextMessage textMessage = Map2Bean.parseText(map,respContent);
//                result = Bean2ResponseXML.textMessageToXml(textMessage);
	           }
	            //取消订阅
	            else if (eventType.equals("unsubscribe")) {
	                // TODO
	                return null;
	            }
	            //点击菜单
	            else if (eventType.equals("CLICK")) {
	                // TODO 
	                return null;
	            }
	        }
	        return result;
	    }
	}


