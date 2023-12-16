import lxml
import requests
from bs4 import BeautifulSoup
import re
import time
import json


link = f"https://onefootball.com/en/competition/premier-league-9/table"
source = requests.get(link).text
page = BeautifulSoup(source, "lxml")

standingsli = page.find_all("li", class_="Standing_standings__row__5sdZG Standing_standings__rowLink__Skr86")

fixlis = []
for i in range(len(standingsli)):
    stand = {}
    mindivs  = standingsli[i].find_all("div", class_="Standing_standings__cell__5Kd0W")
#         print(len(mindivs))
    stand["position"] = mindivs[0].find("span").text
    stand["team"] = standingsli[i].find("p", class_="title-7-medium Standing_standings__teamName__psv61").text
    stand["icon"] = standingsli[i].find("img", class_="EntityLogo_entityLogoImage__4X0wF")["src"]
    stand["PL"] = standingsli[i].find_all("div", class_="Standing_standings__cell__5Kd0W Standing_standings__cellTextDimmed__vpZYH")[0].text
    stand["GD"] = standingsli[i].find_all("div", class_="Standing_standings__cell__5Kd0W Standing_standings__cellTextDimmed__vpZYH")[1].text
    stand["W"] = standingsli[i].find_all("div", class_="Standing_standings__cell__5Kd0W Standing_standings__cellLargeScreen__ttPap Standing_standings__cellTextDimmed__vpZYH")[0].text
    stand["D"] = standingsli[i].find_all("div", class_="Standing_standings__cell__5Kd0W Standing_standings__cellLargeScreen__ttPap Standing_standings__cellTextDimmed__vpZYH")[1].text
    stand["L"] = standingsli[i].find_all("div", class_="Standing_standings__cell__5Kd0W Standing_standings__cellLargeScreen__ttPap Standing_standings__cellTextDimmed__vpZYH")[2].text
    stand["PTS"] = mindivs[7].find("span").text
    
                


    fixlis.append(stand)

with open("public/table.json", "w") as file:
    json.dump(fixlis, file)

print("Data stored successfully!")



