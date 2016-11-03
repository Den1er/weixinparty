package team.bupt.weixinparty.process;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import org.dom4j.Document;
import org.dom4j.DocumentException;
import org.dom4j.DocumentHelper;
import org.dom4j.Element;

public class XmlToMap {
	     public static Map parseXml(HttpServletRequest request) throws Exception {
	//    	 public static Map parseXml(String xml) throws Exception {
	        // 从request中取得输入流
	        StringBuffer sb = new StringBuffer();
	        InputStream is = request.getInputStream();
	        InputStreamReader isr = new InputStreamReader(is, "UTF-8");
	        BufferedReader br = new BufferedReader(isr);
	        String s = "";
	        while ((s = br.readLine()) != null) {
	            sb.append(s);
	        }
	        String xml = sb.toString();
	  //      System.out.println(xml);
	        // 读取输入流
	        try {  
	            Map<String, String> map = new HashMap<String, String>();  
	            Document document = DocumentHelper.parseText(xml);  
	            Element nodeElement = document.getRootElement();  
	            List<Element> node = nodeElement.elements();  
	           for (Element e : node) {  
	                
	                map.put(e.getName(), e.getText());  
	                
	           }  
	  //         System.out.println(map);
	            node = null;  
	            nodeElement = null;  
	            document = null;  
	            return map;  
	        } catch (Exception e) {  
	            e.printStackTrace();  
	        }  
          return null;  
	    }  
}

