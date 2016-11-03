package team.bupt.weixinparty.core;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;

import net.sf.json.*;



public class CreatMenu {
	    public String getAccess_token(){  // 获得ACCESS_TOKEN
	    	final String appId = "wx7ab8001bfb2a5293";   
	      final String appSecret = "27d439628e91a1d5e66855d63fd8635f";  //自己的APPIP  和APPSECRET

	      String url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid="+ appId + "&secret=" +appSecret;
	     
	      String accessToken = null;
	     try {
	            URL urlGet = new URL(url);
	            HttpURLConnection http = (HttpURLConnection) urlGet.openConnection();    
	             
	            http.setRequestMethod("GET");      //必须是get方式请求    
	            http.setRequestProperty("Content-Type","application/x-www-form-urlencoded");    
	            http.setDoOutput(true);        
	            http.setDoInput(true);
	            System.setProperty("sun.net.client.defaultConnectTimeout", "30000");//连接超时30秒
	            System.setProperty("sun.net.client.defaultReadTimeout", "30000"); //读取超时30秒
	            http.connect();
	         
	            InputStream is =http.getInputStream();
	            int size =is.available();
	            byte[] jsonBytes =new byte[size];
	            is.read(jsonBytes);
	            String message=new String(jsonBytes,"UTF-8");
	             
	            JSONObject demoJson = JSONObject.fromObject(message); 
	            accessToken = demoJson.getString("access_token");
	             
	   //         System.out.println(message);
	            } catch (Exception e) {
	                e.printStackTrace();
	            }
	       return accessToken;
	    }
	    public int ctMenu() throws IOException {
	 //        String user_define_menu1 = "{\"button\":[{\"type\":\"click\",\"name\":\"项目管理\",\"key\":\"20_PROMANAGE\"},{\"type\":\"click\",\"name\":\"机构运作\",\"key\":\"30_ORGANIZATION\"},{\"name\":\"日常工作\",\"sub_button\":[{\"type\":\"click\",\"name\":\"待办工单\",\"key\":\"01_WAITING\"},{\"type\":\"click\",\"name\":\"已办工单\",\"key\":\"02_FINISH\"},{\"type\":\"click\",\"name\":\"我的工单\",\"key\":\"03_MYJOB\"},{\"type\":\"click\",\"name\":\"公告消息箱\",\"key\":\"04_MESSAGEBOX\"},{\"type\":\"click\",\"name\":\"签到\",\"key\":\"05_SIGN\"}]}]}";
	         String user_define_menu = "{\"button\":[{\"type\":\"view\",\"name\":\"发起聚会\",\"url\":\"http://www.baidu.com/\"}]}";
	         //此处改为自己想要的结构体，替换即可
	         String access_token= getAccess_token();
	         String action = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token="+access_token;
	         try {
	            URL url = new URL(action);
	            HttpURLConnection http = (HttpURLConnection) url.openConnection();    
	             
	            http.setRequestMethod("POST");        
	            http.setRequestProperty("Content-Type","application/x-www-form-urlencoded");    
	            http.setDoOutput(true);        
	            http.setDoInput(true);
	            System.setProperty("sun.net.client.defaultConnectTimeout", "30000");//连接超时30秒
	            System.setProperty("sun.net.client.defaultReadTimeout", "30000"); //读取超时30秒
	            http.connect();
	            OutputStream os= http.getOutputStream();    
	            os.write(user_define_menu.getBytes("UTF-8"));//传入参数    
	            os.flush();
	            os.close();
	         
	            InputStream is =http.getInputStream();
	            int size =is.available();
	            byte[] jsonBytes =new byte[size];
                is.read(jsonBytes);
	            String message=new String(jsonBytes,"UTF-8");
	            System.out.println(message);
	            } catch (MalformedURLException e) {
	                e.printStackTrace();
	            } catch (IOException e) {
	                e.printStackTrace();
	            }    
	        return 0;
	    }
	}


