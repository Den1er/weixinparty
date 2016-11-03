package team.bupt.weixinparty.util;

import java.io.IOException;
import java.io.InputStream;
import java.io.Writer;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.dom4j.Document;
import org.dom4j.DocumentHelper;
import org.dom4j.Element;
import org.dom4j.io.SAXReader;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

import team.bupt.weixinparty.resp.Article;
import team.bupt.weixinparty.resp.MusicMessage;
import team.bupt.weixinparty.resp.NewsMessage;
import team.bupt.weixinparty.resp.TextMessage;
import com.thoughtworks.xstream.XStream;
import com.thoughtworks.xstream.core.util.QuickWriter;
import com.thoughtworks.xstream.io.HierarchicalStreamWriter;
import com.thoughtworks.xstream.io.xml.PrettyPrintWriter;
import com.thoughtworks.xstream.io.xml.XppDriver;

/**
 * ��Ϣ������
 * 
 */
public class MessageUtil {

	/**
	 * ����΢�ŷ���������XML��
	 * 
	 * @param request
	 * @return
	 * @throws Exception
	 */
/*	public static Map parseXml(String xml) {  
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
	
	
	
	
	
/*	public static Map<String, String> parseXml(HttpServletRequest request) throws Exception {
		// ����������洢��HashMap��
		Map<String, String> map = new HashMap<String, String>();

		// ��request��ȡ��������
		InputStream inputStream = request.getInputStream();
		// ��ȡ������
		SAXReader reader = new SAXReader();
//		Document document =DocumentHelper.parseText(reader)
        Document document = reader.read(inputStream); 
		// �õ�xml��Ԫ��
		Element root = document.getRootElement();
		// �õ���Ԫ�ص������ӽڵ�
		
		@SuppressWarnings("unchecked")
		List<Element> elementList = root.elements();

		// ���������ӽڵ�
		for (Element e : elementList)
			map.put(e.getName(), e.getText());
		// �ͷ���Դ
/*		SAXParser parser;
		SAXParserFactory factory=SAXParserFactory.newInstance();
		try{
			parser=factory.newSAXParser();
			parser.parse(inputStream, new DefaultHandler());
		}catch(ParserConfigurationException e){
			e.printStackTrace();			
		}catch(SAXException e){
			e.printStackTrace();			
		}catch(IOException e){
			e.printStackTrace();			
		}
		inputStream.close();	
		inputStream = null;

		return map;

		
	}
*/
	/**
	 * �ı���Ϣ����ת����xml
	 * 
	 * @param textMessage �ı���Ϣ����
	 * @return xml
	 */
	public static String textMessageToXml(TextMessage textMessage) {
		xstream.alias("xml", textMessage.getClass());
		return xstream.toXML(textMessage);
	}

	/**
	 * ������Ϣ����ת����xml
	 * 
	 * @param musicMessage ������Ϣ����
	 * @return xml
	 */
	public static String musicMessageToXml(MusicMessage musicMessage) {
		xstream.alias("xml", musicMessage.getClass());
		return xstream.toXML(musicMessage);
	}

	/**
	 * ͼ����Ϣ����ת����xml
	 * 
	 * @param newsMessage ͼ����Ϣ����
	 * @return xml
	 */
	public static String newsMessageToXml(NewsMessage newsMessage) {
		xstream.alias("xml", newsMessage.getClass());
		xstream.alias("item", new Article().getClass());
		return xstream.toXML(newsMessage);
	}

	/**
	 * ��չxstream��ʹ��֧��CDATA��
	 * 
	 */
	private static XStream xstream = new XStream();
/*	private static XStream xstream = new XStream(new XppDriver() {
		public HierarchicalStreamWriter createWriter(Writer out) {
			return new PrettyPrintWriter(out) {
				// ������xml�ڵ��ת��������CDATA���
				boolean cdata = true;
				protected void writeText(QuickWriter writer, String text) {
					if (cdata) {
						writer.write("<![CDATA[");
						writer.write(text);
						writer.write("]]>");
					} else {
						writer.write(text);
					}
				}
			};
		}
	});*/
	
	
}

