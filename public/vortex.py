import pygame
import math
import random
from pygame.locals import *
import sys
import matplotlib.pyplot as plt



# parametres de la fonction python : rayon cercle, couleur fond, couleur trait,


cercle1_rayon = int(sys.argv[1])
espaces = int(sys.argv[2])
traits = int(sys.argv[3])
angle = int(sys.argv[4])

'''
cercle1_rayon = 100     #min 1 max 400
espaces = 50            # min 10 max 1000
traits = 10             # min 10 max 150
angle = 10              # 15 avg max 150
'''



pygame.init()       #démarr

surface = pygame.surface.Surface((800, 800)) #crée la fenetre avec une certaine dimension.
surface.fill((0, 0, 0))     #remplis la fenetre avec une couleur


x = 400
y = 400

for i in range(14):
  for l in range(traits):   #min 10 max 150
    pygame.draw.line(surface, (random.randint(0, 255), random.randint(0, 255), random.randint(0, 255)), [400 + 1200 * math.cos(x + 600), 400 + 1200 * math.sin(y + 600)], [400 + cercle1_rayon * math.cos(x + angle), 400 +cercle1_rayon * math.sin(y + angle)], 1)
    pygame.display.flip()
    x += 0.005
    y += 0.005

  for q in range(espaces):   #min 10 max 1000
    x += 0.02
    y += 0.02


fig=plt.figure();

fichier='vortex.png'
fig.savefig(fichier)
print(fichier)
