import lxml
import requests
from bs4 import BeautifulSoup
import re
import time
import json


link = f"https://onefootball.com/en/competition/premier-league-9/fixtures"
source = requests.get(link).text
page = BeautifulSoup(source, "lxml")

fixturesul = page.find_all("ul", class_="MatchCardsList_matches__8_UwB")


def get_fixtures_list():
    fixlis = []
    for i in range(len(fixturesul)):
        fixli = fixturesul[i].find_all("li")
        for i in range (len(fixli)):
            fixlis.append(fixli[i])

    return fixlis


def get_matches_list(fixlis):
    matches = []
    for i in range(len(fixlis)):
        teams = fixlis[i].find_all("span", class_="SimpleMatchCardTeam_simpleMatchCardTeam__name__7Ud8D")
        
        team1 = teams[0].text
        team2 = teams[1].text
        date = fixlis[i].find("time", class_="title-8-bold")
        time = fixlis[i].find("time", class_="SimpleMatchCard_simpleMatchCard__infoMessage___NJqW")
        
        teamicons = fixlis[i].find_all("img", class_="ImageWithSets_of-image__img__pezo7")
        
        match = {}
        match["team1"] = team1
        match["team2"] = team2
        match["date"] = date.text
        match["time"] = time["datetime"]
        match["team1icon"] = teamicons[0]['src']
        match["team2icon"] =  teamicons[1]['src']
        
        
        matches.append(match)

    return matches



li  = get_fixtures_list()

mat  = get_matches_list(li)

with open("livetv/public/fixtures_data.json", "w") as file:
    json.dump(mat, file)

print("Data stored successfully!")



