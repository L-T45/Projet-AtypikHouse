<?php

namespace App\Entity;

use App\Repository\PropertiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Resolver\PostPictureResolver;

// Ajout route personalisé ici (lastnewproperties, dashboard_admin_properties, dashboard_admin_properties_id, dashboard_user_properties_id, dashboard_owner_properties_create, dashboard_owner_properties_{id}, properties_{id}_comments) car pas possible à un autre endroit visiblement.
/**
 * @ORM\Entity(repositoryClass=PropertiesRepository::class)
 * @Vich\Uploadable()
 * @ApiResource(
 *      normalizationContext={"groups"={"properties:collection"}},
 *      denormalizationContext={"groups"={"properties:write"}},
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                 "lastnewproperties"={
 *                 "method"="GET",
 *                 "path"="home/lastproperties",
 *                 "controller"=App\Controller\LastNewProperties::class,
 *                 "force_eager"=false,
 *                 "normalization_context"={"groups"={"properties:collection", "enable_max_depth"=true}}
 *                 },
 *                  "properties_map"={
 *                  "method"="GET",
 *                  "path"="properties/map",
 *                  "force_eager"=false,
 *                  "pagination_enabled"= false,
 *                  "normalization_context"={"groups"={"properties:collection", "properties:map", "enable_max_depth"=true}}
 *                 },
 *                  "properties_ids"={
 *                  "method"="GET",
 *                  "path"="properties/ids",
 *                  "force_eager"=false,
 *                  "pagination_enabled"= false,
 *                  "normalization_context"={"groups"={"properties:ids", "enable_max_depth"=true}}
 *                 }, 
 *                  "dashboard/admin/properties"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/properties",
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                  "normalization_context"={"groups"={"admin:properties", "enable_max_depth"=true}}, 
 *                 }, 
 *              
 *              "api/dashboard/owner/properties/create"={
 *                  "method"="POST",
 *                  "path"="dashboard/owner/properties/create",
 *                  "security"= "is_granted('ROLE_USER')",
 *                  "deserialize" = false,
 *                  "security"= "is_granted('ROLE_USER')",
 *                  "controller"=App\Requests\CreateProperties::class,
 *                  "openapi_context" = {
 *                  "requestBody" = {
 *                     "content" = {
 *                         "multipart/form-data" = {
 *                             "schema" = {
 *                                 "type" = "object",
 *                                 "properties" = {
 *                                     "title" ={
 *                                        "type" = "string"
 *                                      },
 *                                     "slug" ={
 *                                        "type" = "string"
 *                                      },
 *                                      "price" ={
 *                                        "type" = "int"
 *                                      },
 *                                       "rooms" ={
 *                                        "type" = "int"
 *                                      },
 *                                       "booking" ={
 *                                        "type" = "int"
 *                                      },
 *                                       "address" ={
 *                                        "type" = "string"
 *                                      },
 *                                       "city" ={
 *                                        "type" = "string"
 *                                      }, 
 *                                       "latitude" ={
 *                                        "type" = "float"
 *                                      },
 *                                       "longitude" ={
 *                                        "type" = "float"
 *                                      }, 
 *                                       "bedrooms" ={
 *                                        "type" = "int"
 *                                      },
 *                                      "surface" ={
 *                                        "type" = "int"
 *                                      },
 *                                      "reference" ={
 *                                        "type" = "string"
 *                                      },
 *                                      "zipCode" ={
 *                                        "type" = "int"
 *                                      },
 *                                      "country" ={
 *                                        "type" = "string"
 *                                      },
 *                                      "picture" ={
 *                                        "type" = "string"
 *                                      },
 *                                      "capacity" ={
 *                                        "type" = "int"
 *                                      },
 *                                     "file" = {
 *                                         "type" = "array",
 *                                         "items" = {
 *                                             "type" = "string",
 *                                             "format" = "binary"
 *                                         },
 *                                     },
 *                                 },
 *                             },
 *                         },
 *                     },
 *                 },
 *             },
 *                  
 *               }, 
 * 
 * 
 * 
 * 
 * 
 *          },
 *      itemOperations={
 *          "get"={"normalization_context"={"groups"={"propertiesid:item", "properties:id"}}}, 
 *          "patch"={},
 *          "put"={"security"= "is_granted('ROLE_OWNER', 'ROLE_ADMIN')"},
 *          "delete"={},
 *                "dashboard_admin_properties_id"={
 *                "method"="GET",
 *                "path"= "dashboard/admin/properties/{id}",
 *                "force_eager"=false,
 *                "security"= "is_granted('ROLE_ADMIN')",
 *                "normalization_context"={"groups"={"properties:collection", "properties:item", "admin:propertiesid", "enable_max_depth"=true}}
 *                },
 *                "dashboard_user_properties_id"={
 *                "method"="GET",
 *                "path"= "dashboard/user/properties/{id}",
 *                "force_eager"=false,
 *                "normalization_context"={"groups"={"properties:user", "enable_max_depth"=true}}
 *                },
 *                "comments_properties_id"={
 *                "method"="GET",
 *                "path"= "comments/properties/{id}",
 *                "force_eager"=false,
 *                "normalization_context"={"groups"={"properties:comments", "enable_max_depth"=true}}
 *                },
 *                "dashboard_owner_properties_{id}"={
 *                "method"="GET",
 *                "path"= "dashboard/owner/properties/{id}",
 *                "force_eager"=false,
 *                "security"= "is_granted('ROLE_OWNER')",
 *                "normalization_context"={"groups"={"owner:propertiesid", "enable_max_depth"=true}}
 *                },  
 *                
 *                      "comments_properties_id"={
 *                      "method"="GET",
 *                      "path"= "comments/properties/{id}",
 *                      "force_eager"=false,
 *                      "normalization_context"={"groups"={"properties:comments", "enable_max_depth"=true}}
 *                 },
 *                   "dashboard_owner_properties_{id}"={
 *                      "method"="GET",
 *                      "path"= "dashboard/owner/properties/{id}",
 *                      "force_eager"=false,
 *                      "normalization_context"={"groups"={"owner:propertiesid", "enable_max_depth"=true}}
 *                 },
 * 
 *                   "dashboard/update/properties/{id}"={
 *                      "method"="POST",
 *                      "path"= "dashboard/update/properties/{id}",
 *                      "deserialize" = false,
 *                      "security" = "is_granted('ROLE_OWNER') or is_granted('ROLE_ADMIN')",
 *                      "controller" = App\Controller\UpdatePropertiesController::class,
 *                      "openapi_context" = {
 *                          "requestBody" = {
 *                              "content" = {
 *                                  "multipart/form-data" = {
 *                                      "schema" = {
 *                                          "type" = "object",
 *                                          "properties" = {
 *                                              "title"={
 *                                                  "type" = "string"
 *                                                  },
 *                                                  "slug"={
 *                                                      "type" = "string"
 *                                                  },                            
 *                                                  "price"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "rooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "booking"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "address"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "city"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "latitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "longitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "bedrooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "surface"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "reference"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "zipCode"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "country"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "capacity"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "file" = {
 *                                                      "type" = "array",
 *                                                      "items" = {
 *                                                          "type" = "string",
 *                                                          "format" = "binary"
 *                                                      },
 *                                                  },
 *                                              },
 *                                          },
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      }, 
 * 
 *                      "updateinfos/properties/{id}"={
 *                      "method"="POST",
 *                      "path"= "updateinfos/properties/{id}",
 *                      "deserialize" = false,
 *                      "security" = "is_granted('ROLE_OWNER') or is_granted('ROLE_ADMIN')",
 *                      "controller" = "App\Controller\UpdatePropertiesController::updateInfos",
 *                      "openapi_context" = {
 *                          "requestBody" = {
 *                              "content" = {
 *                                  "multipart/form-data" = {
 *                                      "schema" = {
 *                                          "type" = "object",
 *                                          "properties" = {
 *                                              "title"={
 *                                                  "type" = "string"
 *                                                  },
 *                                                  "slug"={
 *                                                      "type" = "string"
 *                                                  },                            
 *                                                  "price"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "rooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "booking"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "address"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "city"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "latitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "longitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "bedrooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "surface"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "reference"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "zipCode"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "country"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "capacity"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "file" = {
 *                                                      "type" = "array",
 *                                                      "items" = {
 *                                                          "type" = "string",
 *                                                          "format" = "binary"
 *                                                      },
 *                                                  },
 *                                              },
 *                                          },
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      }, 
 * 
 * 
 *                      "dashboard/updatecaracteristics/properties/{id}"={
 *                      "method"="POST",
 *                      "path"= "dashboard/updatecaracteristics/properties/{id}",
 *                      "deserialize" = false,
 *                      "security" = "is_granted('ROLE_OWNER') or is_granted('ROLE_ADMIN')",
 *                      "controller" ="App\Controller\UpdatePropertiesController::updateCaracteristics",
 *                      "openapi_context" = {
 *                          "requestBody" = {
 *                              "content" = {
 *                                  "multipart/form-data" = {
 *                                      "schema" = {
 *                                          "type" = "object",
 *                                          "properties" = {
 *                                              "title"={
 *                                                  "type" = "string"
 *                                                  },
 *                                                  "slug"={
 *                                                      "type" = "string"
 *                                                  },                            
 *                                                  "price"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "rooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "booking"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "address"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "city"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "latitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "longitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "bedrooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "surface"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "reference"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "zipCode"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "country"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "capacity"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "file" = {
 *                                                      "type" = "array",
 *                                                      "items" = {
 *                                                          "type" = "string",
 *                                                          "format" = "binary"
 *                                                      },
 *                                                  },
 *                                              },
 *                                          },
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      }, 
 * 
 *                      "dashboard/updateequipements/properties/{id}"={
 *                      "method"="POST",
 *                      "path"= "dashboard/updateequipements/properties/{id}",
 *                      "deserialize" = false,
 *                      "security" = "is_granted('ROLE_OWNER') or is_granted('ROLE_ADMIN')",
 *                      "controller" ="App\Controller\UpdatePropertiesController::updateEquipements",
 *                      "openapi_context" = {
 *                          "requestBody" = {
 *                              "content" = {
 *                                  "multipart/form-data" = {
 *                                      "schema" = {
 *                                          "type" = "object",
 *                                          "properties" = {
 *                                              "title"={
 *                                                  "type" = "string"
 *                                                  },
 *                                                  "slug"={
 *                                                      "type" = "string"
 *                                                  },                            
 *                                                  "price"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "rooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "booking"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "address"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "city"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "latitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "longitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "bedrooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "surface"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "reference"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "zipCode"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "country"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "capacity"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "file" = {
 *                                                      "type" = "array",
 *                                                      "items" = {
 *                                                          "type" = "string",
 *                                                          "format" = "binary"
 *                                                      },
 *                                                  },
 *                                              },
 *                                          },
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      }, 
 *      
 *                      "dashboard/updatenewgallerypictures/properties/{id}"={
 *                      "method"="POST",
 *                      "path"= "dashboard/updatenewgallerypictures/properties/{id}",
 *                      "deserialize" = false,
 *                      "security" = "is_granted('ROLE_OWNER') or is_granted('ROLE_ADMIN')",
 *                      "controller" ="App\Controller\UpdatePropertiesController::insertNewGalleryPictures",
 *                      "openapi_context" = {
 *                          "requestBody" = {
 *                              "content" = {
 *                                  "multipart/form-data" = {
 *                                      "schema" = {
 *                                          "type" = "object",
 *                                          "properties" = {
 *                                              "title"={
 *                                                  "type" = "string"
 *                                                  },
 *                                                  "slug"={
 *                                                      "type" = "string"
 *                                                  },                            
 *                                                  "price"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "rooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "booking"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "address"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "city"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "latitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "longitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "bedrooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "surface"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "reference"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "zipCode"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "country"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "capacity"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "file" = {
 *                                                      "type" = "array",
 *                                                      "items" = {
 *                                                          "type" = "string",
 *                                                          "format" = "binary"
 *                                                      },
 *                                                  },
 *                                              },
 *                                          },
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      }, 
 * 
 *                      "dashboard/updatelocality/properties/{id}"={
 *                      "method"="POST",
 *                      "path"= "dashboard/updatelocality/properties/{id}",
 *                      "deserialize" = false,
 *                      "security" = "is_granted('ROLE_OWNER') or is_granted('ROLE_ADMIN')",
 *                      "controller" ="App\Controller\UpdatePropertiesController::updateLocality",
 *                      "openapi_context" = {
 *                          "requestBody" = {
 *                              "content" = {
 *                                  "multipart/form-data" = {
 *                                      "schema" = {
 *                                          "type" = "object",
 *                                          "properties" = {
 *                                              "title"={
 *                                                  "type" = "string"
 *                                                  },
 *                                                  "slug"={
 *                                                      "type" = "string"
 *                                                  },                            
 *                                                  "price"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "rooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "booking"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "address"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "city"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "latitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "longitude"={
 *                                                      "type" = "float"
 *                                                  },
 *                                                  "bedrooms"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "surface"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "reference"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "zipCode"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "country"={
 *                                                      "type" = "string"
 *                                                  },
 *                                                  "capacity"={
 *                                                      "type" = "int"
 *                                                  },
 *                                                  "file" = {
 *                                                      "type" = "array",
 *                                                      "items" = {
 *                                                          "type" = "string",
 *                                                          "format" = "binary"
 *                                                      },
 *                                                  },
 *                                              },
 *                                          },
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      }, 
 *     
 *                  }
 * )
 * @ApiFilter(SearchFilter::class, properties= {"categories.id": "exact", "equipements.title": "exact", "categories.title": "exact", "latitude": "exact", "longitude": "exact", "reservations.comments.value": "exact", "address": "partial", "city": "partial"})
 * @ApiFilter(RangeFilter::class, properties= {"surface", "rooms", "bedrooms", "price", "capacity"})
 * @ApiFilter(DateFilter::class, properties= {"reservations.startdate"})
 * @ApiFilter(OrderFilter::class, properties= {"price": "ASC", "price": "DESC", "surface": "ASC", "surface" : "DESC", "rooms": "ASC", "rooms": "DESC", "capacity": "ASC", "capacity": "DESC"})
 * 
 */
class Properties
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"properties:collection", "propertiesid:item", "properties:ids", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "admin:users", "admin:usersid", "admin:commentsid", "admin:comments", "lastcomments:collection", "admin:proequip", "admin:categoriesid", "equipements:item", "admin:properties", "owner:propertiesid", "owner:reservid", "owner:properties", "read:commentsid", "read:commentsperso", "read:commentsid", "reservations:user", "categories:item", "comments:item", "user:properties", "propertiesgallery:item", "properties:user", "properties:reports", "propertiesgalleryphoto:create", "properties:reservations"})
     * 
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:collection", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "properties:write", "admin:users", "admin:usersid", "admin:commentsid", "propertiesid:item", "admin:comments", "admin:proequip", "admin:categoriesid", "equipements:item", "admin:properties", "owner:properties", "owner:propertiesid", "owner:reservid",  "read:commentsperso", "read:commentsid", "categories:item", "reservations:user", "user:properties", "propertiesgallery:item", "properties:user", "properties:create"})
     *
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:write", "propertiesid:item", "properties:item", "owner:propertiesid", "user:properties"})
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"admin:commentsid", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "admin:properties", "admin:usersid", "propertiesid:item", "owner:reservid", "properties:item", "owner:propertiesid", "categories:item", "reservations:user", "read:commentsid", "properties:collection", "properties:create"})
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"admin:commentsid", "propertiesid:item", "properties:item", "owner:propertiesid", "categories:item", "read:commentsid", "properties:collection"})
     */
    private $rooms;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:collection", "propertiesid:item", "admin:commentsid", "admin:properties", "owner:properties", "owner:propertiesid", "owner:reservid", "user:properties", "categories:item", "reservations:user"})
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"properties:item", "propertiesid:item", "owner:propertiesid"})
     */
    private $booking;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:collection", "propertiesid:item", "admin:properties", "owner:properties", "owner:propertiesid", "owner:reservid", "user:properties", "categories:item", "reservations:user"})
     * 
     */
    private $city;

    /**
     * @ORM\Column(type="float")
     * @Groups({"propertiesid:item", "properties:item", "owner:propertiesid", "properties:collection"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({"propertiesid:item", "properties:item", "owner:propertiesid", "properties:collection"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"admin:commentsid", "propertiesid:item", "properties:item", "categories:item", "owner:propertiesid", "read:commentsid", "properties:collection"})
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"propertiesid:item", "admin:properties", "admin:commentsid", "properties:item","categories:item", "read:commentsid", "properties:collection", "owner:propertiesid"})
     */
    private $surface;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:item", "owner:propertiesid", "propertiesid:item"})
     */
    private $reference;
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:collection", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "owner:reservid", "admin:usersid", "propertiesid:item", "admin:comments", "lastcomments:collection", "admin:commentsid", "read:commentsperso", "admin:properties", "owner:propertiesid", "owner:properties", "reservations:user", "read:commentsid", "categories:item", "comments:item", "user:properties", "propertiesgallery:item", "lastcomments:collection", "read:reservations"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:item", "propertiesid:item", "owner:propertiesid"})
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"properties:item", "admin:properties",  "propertiesid:item", "categories:item", "owner:propertiesid", "properties:collection"})
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     * @Groups({ "properties:item", "owner:propertiesid", "propertiesid:item"})
     */
    private $zipCode;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({ "properties:item", "owner:propertiesid", "propertiesid:item", "admin:reportsid", "admin:reports", "read:reports", "read:reportsid"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({ "properties:item", "owner:propertiesid", "propertiesid:item"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Equipements::class, inversedBy="properties")
     * @Groups({"properties:write", "properties:item", "owner:propertiesid", "propertiesid:item"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $equipements;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="properties")
     * @Groups({"properties:item", "propertiesid:item", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "admin:usersid", "admin:commentsid", "properties:write", "reservations:user", "owner:propertiesid", "owner:reservid", "admin:properties", "properties:map"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Reservations::class, mappedBy="properties")
     * @Groups({"properties:item", "admin:usertest", "propertiesid:item", "properties:write", "owner:propertiesid", "properties:collection", "properties:map"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $reservations;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="properties")
     * @Groups({"properties:user", "read:reportsid", "admin:reports", "read:reports", "admin:reportsid", "propertiesid:item", "reservations:user", "owner:propertiesid", "owner:reservid"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=PropertiesGallery::class, mappedBy="properties")
     * @Groups({"properties:item", "propertiesid:item", "properties:write", "owner:propertiesid"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $propertiesGalleries;

    /**
     * @ORM\OneToMany(targetEntity=Reports::class, mappedBy="properties")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $reports;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="properties_images", fileNameProperty="picture")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $filePath;

    /**
     * @var string|null
     * @Groups({"properties:collection", "properties:write"})
     */
    private $fileUrl;

    /**
     * @ORM\OneToMany(targetEntity=AttributesAnswers::class, mappedBy="properties")
     * @Groups({"propertiesid:item"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $attributesAnswers;




    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->propertiesGalleries = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->attributesAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBooking(): ?int
    {
        return $this->booking;
    }

    public function setBooking(int $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Equipements[]
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipements $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
        }

        return $this;
    }

    public function removeEquipement(Equipements $equipement): self
    {
        $this->equipements->removeElement($equipement);

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }


    /**
     * @return Collection|Reservations[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setProperties($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getProperties() === $this) {
                $reservation->setProperties(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection|PropertiesGallery[]
     */
    public function getPropertiesGalleries(): Collection
    {
        return $this->propertiesGalleries;
    }

    public function addPropertiesGallery(PropertiesGallery $propertiesGallery): self
    {
        if (!$this->propertiesGalleries->contains($propertiesGallery)) {
            $this->propertiesGalleries[] = $propertiesGallery;
            $propertiesGallery->setProperties($this);
        }

        return $this;
    }

    public function removePropertiesGallery(PropertiesGallery $propertiesGallery): self
    {
        if ($this->propertiesGalleries->removeElement($propertiesGallery)) {
            // set the owning side to null (unless already changed)
            if ($propertiesGallery->getProperties() === $this) {
                $propertiesGallery->setProperties(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reports[]
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Reports $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setProperties($this);
        }

        return $this;
    }

    public function removeReport(Reports $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getProperties() === $this) {
                $report->setProperties(null);
            }
        }

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }


    /**
     * @return File|null $file
     * @return Properties
     */
    public function setFile(?File $file): Properties
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    /**
     * @return string|null $fileUrl
     * @return Properties
     */
    public function setFileUrl(?string $fileUrl): Properties
    {
        $this->fileUrl = $fileUrl;
        return $this;
    }

    /**
     * @return Collection|AttributesAnswers[]
     */
    public function getAttributesAnswers(): Collection
    {
        return $this->attributesAnswers;
    }

    public function addAttributesAnswer(AttributesAnswers $attributesAnswer): self
    {
        if (!$this->attributesAnswers->contains($attributesAnswer)) {
            $this->attributesAnswers[] = $attributesAnswer;
            $attributesAnswer->setProperties($this);
        }

        return $this;
    }

    public function removeAttributesAnswer(AttributesAnswers $attributesAnswer): self
    {
        if ($this->attributesAnswers->removeElement($attributesAnswer)) {
            // set the owning side to null (unless already changed)
            if ($attributesAnswer->getProperties() === $this) {
                $attributesAnswer->setProperties(null);
            }
        }

        return $this;
    }
}
