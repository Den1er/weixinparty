package team.bupt.weixinparty.servlet;

import java.sql.ResultSet;
import java.sql.SQLException;

import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import team.bupt.weixinparty.util.DBUtils;

public class TestServlet extends HttpServlet{

	protected void doPost(HttpServletRequest request, HttpServletResponse response){
		String time = (String)request.getParameter("Number");
		String sql = "insert into tablename (content) values('" + time + "');";
		DBUtils.executeUpdate(sql);
		
//		String sql1 = "insert into tableName £¨content£© values("+content+");";
//		ResultSet rs = DBUtils.executeQuery(sql);
//		try {
//			rs.close();
//		} catch (SQLException e) {
//			// TODO Auto-generated catch block
//			e.printStackTrace();
//		}
		DBUtils.destory();
	}
}
