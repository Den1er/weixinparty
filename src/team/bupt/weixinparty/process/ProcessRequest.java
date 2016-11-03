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
	       //�ı���Ϣ
	       
	          
            // ����
	 	/*        String result = "";
	         TextMessage textMessage = new TextMessage();
	            textMessage.setToUserName("!CDATA["+"aaaaaaaaa"+"]");// ���ͺͽ�����Ϣ��User���պ��෴
	            textMessage.setFromUserName("!CDATA["+"bbbbbbbbb"+"]");
	            textMessage.setCreateTime(new Date().getTime());// ��Ϣ����ʱ�� �����ͣ�
	            textMessage.setMsgType("!CDATA["+"text"+"]");// �ı�������Ϣ
	            textMessage.setContent("!CDATA["+"Congratulation!!!"+"]");
	            result = MessageUtil.textMessageToXml(textMessage);
	            Map<String, String> map =XmlToMap.parseXml(request);
	            System.out.println("oooooooooooo");
	            System.out.println(map);
	            System.out.println("oooooooooooo");*/
	       if (msgType.equals("text")) {
	            TextMessage textMessage = new TextMessage();
	            textMessage.setToUserName(map.get("FromUserName"));// ���ͺͽ�����Ϣ��User���պ��෴
	            textMessage.setFromUserName(map.get("ToUserName"));
	            textMessage.setCreateTime(new Date().getTime());// ��Ϣ����ʱ�� �����ͣ�
	            textMessage.setMsgType("!CDATA["+"text"+"]");// �ı�������Ϣ
	            textMessage.setContent("!CDATA["+"Congratulation!!!"+"]");
	            
	            // // // �ڶ��������������Ϣת��Ϊ΢��ʶ���xml��ʽ���ٶȣ�xstream beanתxm      
	              result = MessageUtil.textMessageToXml(textMessage);
	           

	        }
	        //ͼƬ��Ϣ
	      else if (msgType.equals("image")) {
	            respContent = "";
	            return null;
	        }
	        //������Ϣ
	        else if (msgType.equals("voice")) {
	            respContent = "";
	            return null;
	        }
	        //��Ƶ��Ϣ
	        else if (msgType.equals("video")) {
	            respContent = "";
	            return null;
	        }
	        //����λ��
	        else if (msgType.equals("location")) {
	            respContent = "";
	            return null;
	        }
	        //�¼�����
	        else if (msgType.equals("event")) {
	            String eventType = map.get("Event");
	            //����
	           if (eventType.equals("subscribe")) {
	  //             respContent = "��ӭ�����ҵĹ��ںţ�";
	//               TextMessage textMessage = Map2Bean.parseText(map,respContent);
//                result = Bean2ResponseXML.textMessageToXml(textMessage);
	           }
	            //ȡ������
	            else if (eventType.equals("unsubscribe")) {
	                // TODO
	                return null;
	            }
	            //����˵�
	            else if (eventType.equals("CLICK")) {
	                // TODO 
	                return null;
	            }
	        }
	        return result;
	    }
	}


